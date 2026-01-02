<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\AnalyticSession;
use App\Models\AnalyticPageView;

class AnalyticMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    protected $timeoutMinutes = 1440; // 24 jam

    public function handle(Request $request, Closure $next)
    {
        if (!$this->shouldTrack($request)) {
            return $next($request);
        }

        // cek visitor_uuid di request attribute atau cookie
        $visitorUuid = $request->attributes->get('visitor_uuid');

        if (!$visitorUuid) {
            $visitorUuid = $request->cookie('visitor_uuid') ?? (string) Str::uuid();
            $request->attributes->set('visitor_uuid', $visitorUuid);
        }

        // cari session aktif
        $session = AnalyticSession::where('visitor_uuid', $visitorUuid)
            ->where('last_activity_at', '>=', now()->subMinutes($this->timeoutMinutes))
            ->latest('last_activity_at')
            ->first();

        // buat session baru jika tidak ada
        if (!$session) {
            $session = AnalyticSession::create([
                'visitor_uuid'     => $visitorUuid,
                'started_at'       => now(),
                'last_activity_at' => now(),
                'page_count'       => 0,
            ]);
        }

        // catat page view jika tidak duplikat, dalam 15 detik
        $path = $request->path() === '/' ? '/' : '/' . ltrim($request->path(), '/');
        $recentViewExists = AnalyticPageView::where('analytic_session_id', $session->id)
            ->where('path', $path)
            ->where('created_at', '>=', now()->subSeconds(15))
            ->exists();

        if (!$recentViewExists) {
            AnalyticPageView::create([
                'analytic_session_id' => $session->id,
                'path'       => $path,
                'created_at' => now(),
            ]);

            $session->increment('page_count');
        }

        // update last activity
        $session->update([
            'last_activity_at' => now(),
        ]);

        $response = $next($request);

        // set cookie jika baru durasi 1 tahun
        if (!$request->cookie('visitor_uuid')) {
            $response->cookie(
                'visitor_uuid',
                $visitorUuid,
                60 * 24 * 365, // 1 tahun
                '/',
                null,
                false,
                true,
                false,
                'Lax'
            );
        }

        return $response;
    }

    protected function shouldTrack(Request $request): bool
    {
        // hanya GET
        if (!$request->isMethod('get')) {
            return false;
        }

        // exclude prefix route tertentu
        if ($request->is([
            'api/*',
            'admin/*',
            'dashboard',
            'studio/*',
            'verify-email/*',
            'forgot-password',
            'login',
            'register',
            'logout',
            'livewire/*',
        ])) {
            return false;
        }

        // asset statis
        if (preg_match('/\.(css|js|png|jpg|jpeg|gif|svg|ico|woff|woff2|map)$/i', $request->path())) {
            return false;
        }

        // bot sederhana
        $ua = strtolower($request->userAgent() ?? '');
        if (str_contains($ua, 'bot') || str_contains($ua, 'crawl') || str_contains($ua, 'spider')) {
            return false;
        }

        return true;
    }
}
