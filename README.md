# CakePHP Application Skeleton with [Flat Admin v2](https://github.com/tui2tone/flat-admin-bootstrap-templates) as default template

[![Build Status](https://travis-ci.org/crabstudio/app.svg?branch=master)](https://travis-ci.org/crabstudio/app) [![License](https://img.shields.io/packagist/l/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app) [![Latest Stable Version](https://poser.pugx.org/crabstudio/app/v/stable)](https://packagist.org/packages/crabstudio/app) [![Total Downloads](https://poser.pugx.org/crabstudio/app/downloads)](https://packagist.org/packages/crabstudio/app) [![Latest Unstable Version](https://poser.pugx.org/crabstudio/app/v/unstable)](https://packagist.org/packages/crabstudio/app)

A skeleton for creating applications with [CakePHP](http://cakephp.org) 3.x.

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## Donate

Buy me a cup of coffee [![paypal](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=anhtuank7c%40hotmail%2ecom&lc=US&item_name=Crabstudio%20CakePHP%203%20%2d%20FlatAdmin%20Skeleton&item_number=crabstudio%2dcakephp%2dskeleton&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest)

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

use `Configurations` in backend to control your configurations

#### Important

Change `App.fullBaseUrl` from `false` to `http://your_domain.com` in production, because of Email task will use this to generate url

## Migration

Setup database connection in `config/app.php` first

Open terminal/command line then execute migration
```
bin/cake migrations migrate
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

Edit `src/Template/Element/Admin/navbar_side.ctp` to add more menu

## Included Plugins

[MinifyHtml](https://github.com/WyriHaximus/MinifyHtml)

[TinyAuth](https://github.com//dereuromark/cakephp-tinyauth)

[CookieAuth](https://github.com/Xety/Cake3-CookieAuth)

[Search](https://github.com/friendsofcake/search)

## Backend Template:

This skeleton use [Flat Admin v2](https://github.com/tui2tone/flat-admin-bootstrap-templates) as new bake template

You just do bake code, you're good to go.

## Job schedule:

Open crontab `crontab -e` then add cronjob:

```
*/5 * * * * cd /path/to/app && bin/cake Scheduler.Scheduler
```

If you want to add more job, you just needed to create Task class inside `app/src/Shell/Task` then write

to configure:

```
Configure::write('SchedulerShell.jobs', array(
    'CleanUp' => array('interval' => 'next day 5:00', 'task' => 'CleanUp'),// tomorrow at 5am
    'Newsletters' => array('interval' => 'PT15M', 'task' => 'Newsletter') //every 15 minutes
));
```

# Demo

![Login page](http://image.prntscr.com/image/1e676ca9184e4af78f1cae85b8b294e5.png)

![Lost password](http://image.prntscr.com/image/4b7027688ba346d792c3dc3c64144a7d.png)

![Register](http://image.prntscr.com/image/1f0b3c15b82a4cd78b1bf9119734e794.png)

![Maintenance mode](http://image.prntscr.com/image/a43e3a8973ca4febaa2543981fb0c978.png)

# CRUD

![Index](http://image.prntscr.com/image/3db718250128448a8a35737b26eb8ddb.png)

![Add](http://image.prntscr.com/image/6d35fdbc998e431b8e8054aedb253bb8.png)

![Edit](http://image.prntscr.com/image/46a6870ee9dc4804b081dc9a232d268c.png)

![View](http://image.prntscr.com/image/8e820a4daf244d7f99b77d0a7b23e4e1.png)

# Page speed improvement

- [Google pagespeed mod](https://developers.google.com/speed/pagespeed/module/) on your server

	`.htaccess` already setup mod expires and deflate/gzip, you have to setup these mods

- [mod_expires apache](http://httpd.apache.org/docs/current/mod/mod_expires.html), [expires nginx](https://gist.github.com/anhtuank7c/fa03b1dae5bc71a246af)

- [mod_deflate apache](http://httpd.apache.org/docs/current/mod/mod_deflate.html), [gzip nginx](http://aspyct.org/blog/2012/08/20/setting-up-http-cache-and-gzip-with-nginx/)

	`Nodejp` required to use `gulp`

- Install and use [gulp](http://gulpjs.com/), [minify npm](https://github.com/srod/node-minify) to compress your js, css
