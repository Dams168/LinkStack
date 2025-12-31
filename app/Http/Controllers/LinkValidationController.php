<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LinkSafetyService;
use App\Services\LinkUrlValidateService;

class LinkValidationController extends Controller
{
    public function validateLink(Request $request)
    {
        $request->validate([
            'link' => 'required|url',
        ]);
        $result = app(LinkSafetyService::class)->check($request->link);

        return response()->json([
            'status'  => $result['status'],
            'score'   => $result['score'],
            'reasons' => $result['reasons'],
        ]);
    }

    public function validateUrlPredefinedSite(Request $request)
    {
        $request->validate([
            'link'   => 'required|string',
            'button' => 'required|string',
        ]);

        $result = app(LinkUrlValidateService::class)->validate($request->input('button'), $request->input('link'));

        if (!$result['valid']) {
            return response()->json([
                'status' => 'error',
                'message' => $result['message'],
            ], 422);
        }

        return response()->json([
            'status' => 'ok',
        ]);
    }
}
