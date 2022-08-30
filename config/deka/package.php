<?php

// config for Deka/LaravelPackageTools
return [
    'token' => env('GITHUB_TOKEN', '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'),
    'repo' => [
        'production' => env('REPO_PRODUCTION', 'https://repo.deka.dev'),
        'development' => env('REPO_DEVELOPMENT', 'https://repo-deka.test'),
    ],
    'vendors' => array_map('trim', explode(',', env('PACKAGE_VENDOR', 'deka'))),
    'directory' => env('PACKAGE_DIRECTORY', '/Users/riskihajar/deka-packages'),
];
