<?php

return [
    'paths' => [
        base_path('resources/views'),
    ],

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        storage_path('framework/views')
    ),
];
