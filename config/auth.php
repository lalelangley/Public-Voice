<?php
return [

    'defaults' => [
        'guard' => 'petugas', // Default ke petugas/admin
        'passwords' => 'petugas',
    ],

    'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'petugas', // HARUS petugas!
    ],
        'masyarakat' => [
            'driver' => 'session',
            'provider' => 'masyarakat',
        ],
        
        'petugas' => [
            'driver' => 'session',
            'provider' => 'petugas', // Tambahkan ini!
        ],
    ],

    'providers' => [
        'petugas' => [
            'driver' => 'eloquent',
            'model' => App\Models\Petugas::class,
        ],

        'masyarakat' => [
            'driver' => 'eloquent',
            'model' => App\Models\Masyarakat::class,
        ],
    ],

    'passwords' => [
        'petugas' => [
            'provider' => 'petugas',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'masyarakat' => [
            'provider' => 'masyarakat',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],
];
