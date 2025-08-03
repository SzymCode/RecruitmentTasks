<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function () {
    Route::get('', fn () => redirect()->route('home'));
    Route::get('home', fn () => serveNuxtPage('home'))->name('home');
});

/**
 *  Nuxt files integration - my own functionality
 */
if (! function_exists('serveNuxtFile')) {
    function serveNuxtFile($path, $contentType = 'text/html')
    {
        if (! file_exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return response()->file($path, [
            'Content-Type' => $contentType,
            'Cache-Control' => $contentType === 'text/html' ? 'no-cache, no-store, must-revalidate' : 'public, max-age=31536000',
            'Pragma' => 'no-cache',
            'Expires' => '0',
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With, X-XSRF-TOKEN, Referer-Slug',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Expose-Headers' => '*',
        ]);
    }
}

if (! function_exists('serveNuxtPage')) {
    function serveNuxtPage($page)
    {
        return serveNuxtFile(base_path("public/build/{$page}.html"));
    }
}

Route::get('/_payload.json', fn () => serveNuxtFile(base_path('public/build/_payload.json'), 'application/json'));

Route::get('/_nuxt/{path}', function ($path) {
    $mimeTypes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'eot' => 'application/vnd.ms-fontobject',
        'svg' => 'image/svg+xml',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'ico' => 'image/x-icon',
    ];
    $extension = pathinfo($path, PATHINFO_EXTENSION);

    return serveNuxtFile(base_path('public/build/_nuxt/'.$path), $mimeTypes[$extension] ?? 'application/octet-stream');
})->where('path', '.*');

Route::get('/_fonts/{path}', function ($path) {
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    $mimeType = match ($extension) {
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'eot' => 'application/vnd.ms-fontobject',
        default => 'application/octet-stream'
    };

    return serveNuxtFile(base_path('public/build/_fonts/'.$path), $mimeType);
})->where('path', '.*');

Route::get('/{any}', function ($any) {
    $page = trim($any, '/');
    $htmlPath = base_path("public/build/{$page}.html");
    if (file_exists($htmlPath)) {
        return serveNuxtFile($htmlPath);
    }

    return response()->json(['error' => 'Page not found'], 404);
})->where('any', '^(?!api/|logout).+');
