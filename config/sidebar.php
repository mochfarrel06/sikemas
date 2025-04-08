<?php

return [
    // 1. ADMIN
    [
        'text' => 'UTAMA',
        'role' => ['admin', 'pasien', 'dokter'],
        'is_header' => true,
    ],
    [
        'text' => 'Dashboard',
        'url' => '/admin/dashboard',
        'role' => ['admin'],
        'icon' => 'iconoir-dashboard-speed',
    ],
    [
        'text' => 'Dokter',
        'url' => ['/admin/doctors', '/admin/specializations', '/admin/doctor-schedules'],
        'role' => ['admin'],
        'icon' => 'iconoir-group',
        'children' => [
            [
                'text' => 'Dokter',
                'url' => '/admin/doctors',
                'role' => ['admin'],
            ],
            [
                'text' => 'Spesialisasi',
                'url' => '/admin/specializations',
                'role' => ['admin'],
            ],
            [
                'text' => 'Jadwal Dokter',
                'url' => '/admin/doctor-schedules',
                'role' => ['admin'],
            ]
        ],
    ],
    [
        'text' => 'Pasien',
        'url' => '/admin/patients',
        'role' => ['admin'],
        'icon' => 'iconoir-user-square',
    ],

    // 2. Dokter
    [
        'text' => 'Dashboard',
        'url' => '/doctor/dashboard',
        'role' => ['dokter'],
        'icon' => 'iconoir-dashboard-speed',
    ],
    [
        'text' => 'Rekam Medis',
        'url' => '/doctor/medical-record',
        'role' => ['dokter'],
        'icon' => 'iconoir-book',
    ],

    // 3. PASIEN
    [
        'text' => 'Dashboard',
        'url' => '/patient/dashboard',
        'role' => ['pasien'],
        'icon' => 'iconoir-dashboard-speed',
    ],


    [
        'text' => 'ANTREAN',
        'role' => ['admin', 'pasien', 'dokter'],
        'is_header' => true,
    ],
    [
        'text' => 'Antrean Pasien',
        'url' => '/data-patient/queue',
        'role' => ['pasien', 'dokter', 'admin'],
        'icon' => 'iconoir-task-list',
    ],

    [
        'text' => 'Riwayat Antrean Pasien',
        'url' => '/history/queue',
        'role' => ['pasien', 'dokter', 'admin'],
        'icon' => 'iconoir-ease-curve-control-points',
    ],

    [
        'text' => 'Pengguna',
        'role' => ['admin'],
        'is_header' => true,
    ],
    [
        'text' => 'Manajemen Pengguna',
        'url' => '/admin/user-management',
        'role' => ['admin'],
        'icon' => 'iconoir-settings',
    ],

    // Antrean
    // [
    //     'text' => 'ANTREAN',
    //     'role' => ['admin'],
    //     'is_header' => true,
    // ],
    // [
    //     'text' => 'Antrean Pasien',
    //     'url' => '',
    //     'role' => ['admin'],
    //     'icon' => 'iconoir-task-list',
    // ],

    // Setting
    // [
    //     'text' => 'PENGATURAN',
    //     'role' => ['admin'],
    //     'is_header' => true,
    // ],
    // [
    //     'text' => 'Manajemen Pengguna',
    //     'url' => '/admin/patients',
    //     'role' => ['admin'],
    //     'icon' => 'iconoir-group',
    // ],





];
