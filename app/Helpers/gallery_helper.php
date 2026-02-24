<?php

if (! function_exists('gallery_uploads_base_url')) {
    function gallery_uploads_base_url(): string
    {
        static $baseUrl = null;

        if ($baseUrl !== null) {
            return $baseUrl;
        }

        $baseUrl = trim((string) env('gallery.uploadsBaseUrl', ''));

        return $baseUrl === '' ? '' : rtrim($baseUrl, '/');
    }
}

if (! function_exists('gallery_media_url')) {
    function gallery_media_url(?string $value): string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return '';
        }

        $baseUrl = gallery_uploads_base_url();
        if ($baseUrl === '') {
            return $value;
        }

        $value = str_replace('\\', '/', $value);

        if (str_starts_with($value, 'data:') || str_starts_with($value, '//')) {
            return $value;
        }

        $parts = parse_url($value);
        if (is_array($parts) && isset($parts['scheme'])) {
            $path = (string) ($parts['path'] ?? '');
            if (! str_starts_with($path, '/uploads/')) {
                return $value;
            }

            $url = $baseUrl . $path;
            if (isset($parts['query'])) {
                $url .= '?' . $parts['query'];
            }
            if (isset($parts['fragment'])) {
                $url .= '#' . $parts['fragment'];
            }

            return $url;
        }

        if (str_starts_with($value, '/uploads/')) {
            return $baseUrl . $value;
        }

        if (str_starts_with($value, 'uploads/')) {
            return $baseUrl . '/' . $value;
        }

        return $value;
    }
}
