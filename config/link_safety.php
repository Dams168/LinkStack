<?php

return [


    // AUTO BLOCK RULES (HARD BLOCK) -> Jika salah satu rule di sini terpenuhi, URL LANGSUNG diblokir tanpa scoring.

    'auto_block' => [

        // Scheme berbahaya (XSS, RCE)
        'schemes' => [
            'javascript',
            'data',
            'file',
            'ftp',
        ],

        // Proteksi SSRF
        'hosts' => [
            'localhost',
            '127.0.0.1',
        ],

        // Keyword yang melanggar kebijakan platform
        // (contoh: judi, scam, NSFW)
        'blacklist_keywords' => [
            'casino',
            'poker',
            'slot',
            'bet',
            'scam',
            'malware',
            'mahjong',
            'maxwin',
            'porn',
            'xxx',
        ],
    ],


    //  PHISHING DETECTION (SCORING)-> BUKAN auto block karena rawan false positive jadi dikasih warning.

    'phishing' => [
        'keywords' => [
            'login',
            'verify',
            'claim',
            'secure',
            'account',
            'password',
            'free',
            'update',
            'bank',
            'confirm',
            'signin',
            'security',
            'alert',
            'payment',
        ],
        'score' => 50,
    ],

    // REDIRECT & SHORTLINK DETECTION

    'redirect' => [

        // Shortlink service yang sering dipakai
        'shorteners' => [
            'bit.ly',
            's.id',
            'tinyurl',
        ],

        // suspicious domain
        'suspicious_tlds' => [
            'xyz',
            'online',
            'top',
            'click',
            'site',
        ],

        'score' => 30,
    ],

    // GENERAL SUSPICIOUS PATTERN (SCORING)
    'patterns' => [
        // Banyak subdomain
        'max_subdomain' => 3,
        'subdomain_score' => 10,
    ],

    // DECISION THRESHOLD
    'threshold' => [
        'block' => 100,
        'warning' => 50,
    ],

    'http' => [
        'timeout' => 5,
    ],
];
