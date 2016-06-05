# CakePHP Application Skeleton with FlatAdmin as default template

[![Build Status](https://travis-ci.org/crabstudio/app.svg?branch=master)](https://travis-ci.org/crabstudio/app)
[![License](https://img.shields.io/packagist/l/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app)

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

Read and edit `config/flat_admin.php`, `config/recaptcha.php`, `config/html_minify.php` and setup any other
configuration relevant for your application.

## Migration

Setup database connection in `config/app.php` first

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

Edit `src/Template/Element/Admin/navbar_side.ctp` to add more menu

## Included Plugins

[TinyAuth](https://github.com//dereuromark/cakephp-tinyauth)

[Recaptcha](https://github.com/crabstudio/recaptcha)

[EmailQueue](https://github.com/crabstudio/emailqueue)

[CookieAuth](https://github.com/Xety/Cake3-CookieAuth)

[Search](https://github.com/friendsofcake/search)

[Scheduler](https://github.com/trentrichardson/cakephp-scheduler/)

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

![Login page](http://i.imgur.com/OYwbXOQ.png)

![Lost password](http://i.imgur.com/JUyTJKi.png)

![Register](http://i.imgur.com/UNxAcHr.png)

![Maintenance mode](http://i.imgur.com/gtE7lwb.png)

# CRUD

![Index](http://img.prntscr.com/img?url=http://i.imgur.com/YirtdcJ.png)

![Add](http://i.imgur.com/NRJ5rn1.png)

![Edit](http://i.imgur.com/4Hl8sbG.png)

![View](http://i.imgur.com/yHopFTc.png)
