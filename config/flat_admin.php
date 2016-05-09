<?php
return [
    'AllowRegister' => true,
    'Expired' => [
        'register' => '24 hours',
        'reset_password' => '24 hours',
    ],
    'Maintenance' => [
        'enable' => false,
        'allowedIp' => '127.0.0.*, 192.168.1.10'
    ],
    'Menu' => [
        'Side' => [],
        'Top' => []
    ],
    'Meta' => [
        'brandname' => 'CakePHP',
        'copyright' => '<b>CakePHP</b> all right reserved',
        'version' => '1.0',
        'keywords' => 'crabstudio, anhtuank7c, cakephp3, backend, flat-admin',
        'description' => 'A completed simple admin backend [roles, users, login, logout, register, forgot password etc...]',
        'logo' => '/img/logo.png',
    ],
    'Recaptcha' => [
        'type' => 'image',
        'theme' => 'light',
        'lang' => 'en',
        'enable' => true,
        'sitekey' => '6LfrSAwTAAAAAOh0GKAG0z6u6MLzBlP8oRzRxPgs',
        'secret' => '6LfrSAwTAAAAAJFqGoSwG7VP7Qw8lLQTmjLo4cED',
    ],
    'WyriHaximus' => [
        'MinifyHtml' => [
            'debugOverride' => false,
            'factory' => 'WyriHaximus\HtmlCompress\Factory::constructSmallest',
        ],
    ],
];
