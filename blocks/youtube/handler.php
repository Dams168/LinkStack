<?php

/**
 * Handles the logic for "youtube" link type.
 *
 * @param \Illuminate\Http\Request $request The incoming request.
 * @param mixed $linkType The link type information.
 * @return array The prepared validation rules and link data.
 */
function handleLinkType($request, $linkType)
{
    $rules = [
        'link' => [
            'required',
            'url',
            'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\//i',
        ],
        'title' => [
            'required',
            'string',
            'max:255',
        ],
    ];

    $videoId = null;

    if (preg_match('~youtu\.be/([^?]+)~', $request->link, $matches)) {
        $videoId = $matches[1];
    } elseif (preg_match('~v=([^&]+)~', $request->link, $matches)) {
        $videoId = $matches[1];
    }

    $embedUrl = $videoId
        ? 'https://www.youtube.com/embed/' . $videoId
        : null;

    $linkData = [
        'link'      => $embedUrl,
        'title'     => $request->title,
        'button_id' => 41,
    ];

    return [
        'rules'    => $rules,
        'linkData' => $linkData,
    ];
}
