<?php

return [
    'paths' => [
        realpath(base_path('resources/views')),
        '/app/resources/views'
    ],

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),
];
