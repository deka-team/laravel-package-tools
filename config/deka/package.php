<?php

// config for Deka/LaravelPackageTools
return [
    'token' => env('GITHUB_TOKEN'),
    'repo' => [
        'production' => env('REPO_PRODUCTION'),
        'development' => env('REPO_DEVELOPMENT'),
    ],
    'vendors' => array_map('trim', explode(',', env('PACKAGE_VENDOR', 'deka'))),
    'directory' => env('PACKAGE_DIRECTORY'),
];
