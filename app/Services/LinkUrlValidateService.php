<?php

namespace App\Services;

use Illuminate\Support\Arr;

/**
 * Class LinkUrlValidateService
 * @package App\Services
 */
class LinkUrlValidateService{
     protected array $rules;

    public function __construct()
    {
        $this->rules = config('platform_url');
    }

    public function validate(string $button, string $url): array
    {
        if (!isset($this->rules[$button])) {
            return ['valid' => true];
        }

        if (!preg_match('#^https?://#i', $url)) {
            $url = 'https://' . $url;
        }

        $domains = Arr::get($this->rules, "$button.domains", []);
        $error   = Arr::get($this->rules, "$button.error", 'Invalid URL');

        $host = parse_url($url, PHP_URL_HOST);

        if (!$host) {
            return [
                'valid'   => false,
                'message' => $error,
            ];
        }

        foreach ($domains as $domain) {
            if (str_contains($host, $domain)) {
                return ['valid' => true];
            }
        }

        return [
            'valid'   => false,
            'message' => $error,
        ];
    }
}
