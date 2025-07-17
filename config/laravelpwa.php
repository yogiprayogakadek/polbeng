<?php

return [
    'name' => 'Politeknik Negeri Bengkalis',
    'manifest' => [
        'name' => env('APP_NAME', 'Politeknik Negeri Bengkalis'),
        'short_name' => 'Polbeng',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation' => 'any',
        'status_bar' => 'black',
        'icons' => [
            '72x72' => [
                'path' => '/assets/images/logo/pwa/main-logo-72x72.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/assets/images/logo/pwa/main-logo-96x96.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/assets/images/logo/pwa/main-logo-128x128.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/assets/images/logo/pwa/main-logo-144x144.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/assets/images/logo/pwa/main-logo-152x152.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/assets/images/logo/pwa/main-logo-192x192.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '/assets/images/logo/pwa/main-logo-384x384.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/assets/images/logo/pwa/main-logo-512x512.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/assets/images/logo/splash/splash-640x1136.png',
            '750x1334' => '/assets/images/logo/splash/splash-750x1334.png',
            '828x1792' => '/assets/images/logo/splash/splash-828x1792.png',
            '1125x2436' => '/assets/images/logo/splash/splash-1125x2436.png',
            '1242x2208' => '/assets/images/logo/splash/splash-1242x2208.png',
            '1242x2688' => '/assets/images/logo/splash/splash-1242x2688.png',
            '1536x2048' => '/assets/images/logo/splash/splash-1536x2048.png',
            '1668x2224' => '/assets/images/logo/splash/splash-1668x2224.png',
            '1668x2388' => '/assets/images/logo/splash/splash-1668x2388.png',
            '2048x2732' => '/assets/images/logo/splash/splash-2048x2732.png',
        ],
        // 'shortcuts' => [
        //     [
        //         'name' => 'Shortcut Link 1',
        //         'description' => 'Shortcut Link 1 Description',
        //         'url' => '/shortcutlink1',
        //         'icons' => [
        //             "src" => "/images/icons/icon-72x72.png",
        //             "purpose" => "any"
        //         ]
        //     ],
        //     [
        //         'name' => 'Shortcut Link 2',
        //         'description' => 'Shortcut Link 2 Description',
        //         'url' => '/shortcutlink2'
        //     ]
        // ],
        'custom' => []
    ]
];
