<?php
return [
    'Member' => [
        'AnyoneCanRegister' => true,
        'TokenExpired' => [
            'register' => '24 hours',
            'reset_password' => '24 hours',
        ],
    ],
    'Maintenance' => [
        'enable' => false,
        'allowedIp' => '127.0.0.*, 192.168.1.10'
    ],
    'Meta' => [
        'title' => 'CakePHP',
        'keywords' => 'crabstudio, anhtuank7c, cakephp3, backend, flat-admin',
        'description' => 'A completed simple admin backend [roles, users, login, logout, register, forgot password etc...]',
        'logo' => '/img/logo.png',
        'copyright' => '<b>CakePHP</b> all right reserved',
    ],
    'Recaptcha' => [
        'type' => 'image',
        'theme' => 'light',
        'lang' => 'en',
        'enable' => true,
        'sitekey' => '6LfrSAwTAAAAAOh0GKAG0z6u6MLzBlP8oRzRxPgs',
        'secret' => '6LfrSAwTAAAAAJFqGoSwG7VP7Qw8lLQTmjLo4cED',
    ],
    'SchedulerShell' => [
        'jobs' => [
            'EmailSender' => [
                'interval' => 'PT5M', // each 5 minute do send bulk email
                'task' => 'EmailSender',
            ],
        ],
    ],
];
