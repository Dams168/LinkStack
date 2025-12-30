<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
/**
 * Class LinkSafetyService
 * @package App\Services
 */
class LinkSafetyService
{
    public function check(string $url): array
    {
        $score = 0;
        $reasons = [];

        $parsed = parse_url($url);

        $autoBlock = $this->checkAutoBlock($parsed, $url);

        if ($autoBlock !== null) {
            return [
                'status'  => 'blocked',
                'score'   => 100,
                'reasons' => [$autoBlock],
            ];
        }

        $phishing = $this->checkPhishing($parsed);
        if ($phishing) {
            $score += config('link_safety.phishing.score');
            $reasons[] = 'Phishing keyword terdeteksi';
        }

        $redirect = $this->checkRedirect($url, $parsed);
        if ($redirect) {
            $score += config('link_safety.redirect.score');
            $reasons[] = 'Redirect / shortlink mencurigakan';
        }

        $pattern = $this->checkPatterns($parsed);
        if ($pattern) {
            $score += config('link_safety.patterns.subdomain_score');
            $reasons[] = 'Struktur domain mencurigakan';
        }

        return $this->decision($score, $reasons);
    }

    protected function checkAutoBlock(array $parsed, string $url): ?string
    {
        // Cek scheme berbahaya
        if (
            isset($parsed['scheme']) &&
            in_array($parsed['scheme'], config('link_safety.auto_block.schemes'))
        ) {
            return 'Scheme URL berbahaya';
        }

        // Cek host berbahaya
        $host = $parsed['host'] ?? '';
        if (in_array($host, config('link_safety.auto_block.hosts'))) {
            return 'Host lokal / SSRF terdeteksi';
        }

        $ip = gethostbyname($host);
        if (
            filter_var(
                $ip,
                FILTER_VALIDATE_IP,
                FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
            ) === false
        ) {
            return 'Private IP / SSRF terdeteksi';
        }

        // Cek keyword blacklist
        foreach (config('link_safety.auto_block.blacklist_keywords') as $word) {
            if (Str::contains(Str::lower($url), $word)) {
                return 'Melanggar kebijakan platform';
            }
        }

        return null;
    }

    protected function checkPhishing(array $parsed): bool
    {
        $target = Str::lower(
            ($parsed['path'] ?? '') . ($parsed['query'] ?? '')
        );
        foreach (config('link_safety.phishing.keywords') as $keyword) {
            if (Str::contains($target, $keyword)) {
                return true;
            }
        }

        return false;
    }

    protected function checkRedirect(string $url, array $parsed): bool
    {
        $host = $parsed['host'] ?? '';

        if (in_array($host, config('link_safety.redirect.shorteners'))) {
            return true;
        }
        $tld = Str::afterLast($host, '.');
        if (in_array($tld, config('link_safety.redirect.suspicious_tlds'))) {
            return true;
        }

        try {
            $response = Http::timeout(config('link_safety.http.timeout'))
                ->withoutRedirecting()
                ->get($url);

            if ($response->isRedirection()) {
                return true;
            }
        } catch (\Throwable $e) {
            return true;
        }

        return false;
    }

    protected function checkPatterns(array $parsed): bool
    {
        $host = $parsed['host'] ?? '';
        $subdomainCount = substr_count($host, '.');

        return $subdomainCount >= config('link_safety.patterns.max_subdomain');
    }
    protected function decision(int $score, array $reasons): array
    {
        if ($score >= config('link_safety.threshold.block')) {
            return [
                'status'  => 'block',
                'score'   => $score,
                'reasons' => $reasons,
            ];
        }

        if ($score >= config('link_safety.threshold.warning')) {
            return [
                'status'  => 'warning',
                'score'   => $score,
                'reasons' => $reasons,
            ];
        }

        return [
            'status'  => 'safe',
            'score'   => $score,
            'reasons' => [],
        ];
    }

}
