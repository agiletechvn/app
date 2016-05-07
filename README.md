# CakePHP Application Skeleton with FlatAdmin as default template

[![Build Status](https://img.shields.io/travis/cakephp/app/master.svg?style=flat-square)](https://travis-ci.org/cakephp/app)
[![License](https://img.shields.io/packagist/l/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app)

A skeleton for creating applications with [CakePHP](http://cakephp.org) 3.x.

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## Installation

1. Download [Composer](http://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project --prefer-dist crabstudio/app [app_name]`.

If Composer is installed globally, run
```bash
composer create-project --prefer-dist crabstudio/app [app_name]
```

You should now be able to visit the path to where you installed the app and see
the setup traffic lights.

## Configuration

Read and edit `config/app.php` and setup the 'Datasources' and any other
configuration relevant for your application.

Read and edit `config/flat_admin.php`, `config/recaptcha.php`, `config/html_minify.php` and setup any other
configuration relevant for your application.

## Migration

Open terminal/command line then execute migration
```
bin/cake migrations migrate
bin/cake migrations migrate --plugin EmailQueue
```

## Seed

Open terminal/command line then execute migration
```
bin/cake migrations seed
```

Default roles:

- Admin
- Manager
- Member

Default users:

- admin@example.com/admin@1234

## Bake

You can use bake to generate CRUD code, then you're ready to use.

```
bin/cake bake all Posts --prefix admin
```

## Add menu to the backend

Edit `config/flat_admin.php` as bellow

```
<?php
// You can add more menu to the sidebar like this
    'Menu' => [
        'Side' => [
            //link
            [
                '<span class="icon fa fa-edit"></span><span class="title">' . __('Posts') . '</span>', 
                ['prefix' => 'admin', 'controller' => 'Posts', 'action' => 'index']
            ],
            //group link
            [
                '<span class="icon fa fa-cogs"></span><span class="title">' . __('System') . '</span>',
                [
                    [__('Role'), ['prefix' => 'admin', 'controller' => 'Logs', 'action' => 'index']],
                    [__('User'), ['prefix' => 'admin', 'controller' => 'Schedules', 'action' => 'index']],
                ]
            ],
        ],
    ],
```

## Included Plugins

[TinyAuth](github.com/dereuromark/cakephp-tinyauth)

[MinifyHtml](https://github.com/WyriHaximus/MinifyHtml)

[EmailQueue](https://github.com/crabstudio/emailqueue)

[CookieAuth](https://github.com/Xety/Cake3-CookieAuth)

[Search](https://github.com/friendsofcake/search)

## Free Backend Template:

This skeleton use [Flat Admin v2](https://github.com/tui2tone/flat-admin-bootstrap-templates) as backend template

========
# Demo

Login
![Login page](http://i.imgur.com/OYwbXOQ.png)

Lost password
![Lost password](http://i.imgur.com/JUyTJKi.png)

Register
![Register](http://i.imgur.com/UNxAcHr.png)

# CRUD

Index
![Index](http://img.prntscr.com/img?url=http://i.imgur.com/YirtdcJ.png)

Add
![Add](http://i.imgur.com/NRJ5rn1.png)

Edit
![Edit](http://i.imgur.com/4Hl8sbG.png)

View
![View](http://i.imgur.com/yHopFTc.png)
