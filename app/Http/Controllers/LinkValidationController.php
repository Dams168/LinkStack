<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LinkSafetyService;

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
}
