<?php
return [
    'AllowRegister' => true,
    'Expired' => [
        'register' => '24 hours',
        'reset_password' => '24 hours',
    ],
    'Maintenance' => [
        'enable' => false,
        'allowedIp' => '127.0.0.1, ::1, 127.0.0.*'
    ],
    'Menu' => [
        'Side' => [],
        'Top' => []
    ],
    'Meta' => [
        'brandname' => 'Crabstudio',
        'copyright' => '<b>Crabstudio</b> all right reserved',
        'version' => '1.0',
        'keywords' => 'crabstudio, anhtuank7c, cakephp3, backend, flat-admin',
        'description' => ' A completed simple admin backend [roles, users, login, logout, register, forgot password etc...]',
        'logo' => '/img/logo.png'
    ],
];
