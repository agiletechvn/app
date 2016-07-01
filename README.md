# CakePHP Application Skeleton with [Flat Admin v2](https://github.com/tui2tone/flat-admin-bootstrap-templates) as default template

[![Build Status](https://travis-ci.org/crabstudio/app.svg?branch=master)](https://travis-ci.org/crabstudio/app) [![License](https://img.shields.io/packagist/l/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app) [![Latest Stable Version](https://poser.pugx.org/crabstudio/app/v/stable)](https://packagist.org/packages/crabstudio/app) [![Total Downloads](https://poser.pugx.org/crabstudio/app/downloads)](https://packagist.org/packages/crabstudio/app) [![Latest Unstable Version](https://poser.pugx.org/crabstudio/app/v/unstable)](https://packagist.org/packages/crabstudio/app)

A skeleton for creating applications with [CakePHP](http://cakephp.org) 3.x.

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## Features

1. Authenticate, Authorize
2. Backend ready
3. Simple shells => Power tool
4. New CRUD bake template
5. Send bulk email
6. Backup database job
7. Store Settings in database
8. Improve pages peed: .htaccess, minify html, cdn, cache
9. Integrated file manager, tinymce

## Support me [![paypal](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=anhtuank7c%40hotmail%2ecom&lc=US&item_name=Crabstudio%20CakePHP%203%20%2d%20FlatAdmin%20Skeleton&item_number=crabstudio%2dcakephp%2dskeleton&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest)

## Create project

1. Download [Composer](http://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project --prefer-dist crabstudio/app [app_name]`.

If Composer is installed globally, run

```
composer create-project --prefer-dist crabstudio/app [app_name]
```

## Installation

Initial new application

1. Setup `Datasource` in `config/app.php`
2. Run and follow the command: `bin/cake install`
3. Application **ready** to use.

## Refactory

**Incase you want to wipe and reinstall application**

1. Run and follow the command: `bin/cake refactory`
2. Application ready to use.

## Available shell commands

```
	bin/cake install			: install default database
	bin/cake refactory			: wipe existing database then install factory database
	bin/cake users				: insert administrator
	bin/cake roles				: insert 3 default roles [admin, manager, member]
	bin/cake settings			: insert default settings
	bin/cake scheduler 			: run task, let's create crontab schedule [scroll down to Crontab schedule]
```

## Important

Change `App.fullBaseUrl` from `false` to `http://your_domain.com` in production

**EmailSenderTask will use App.fullBaseUrl to generate the url**

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

## Crontab schedule:

Open crontab `crontab -e` then add cronjob:

```
*/5 * * * * cd /path/to/app && bin/cake Scheduler
```

# Demo

![Login page](http://image.prntscr.com/image/1e676ca9184e4af78f1cae85b8b294e5.png)

![Lost password](http://image.prntscr.com/image/4b7027688ba346d792c3dc3c64144a7d.png)

![Register](http://image.prntscr.com/image/1f0b3c15b82a4cd78b1bf9119734e794.png)

![Maintenance mode](http://image.prntscr.com/image/a43e3a8973ca4febaa2543981fb0c978.png)

![File Manager](http://image.prntscr.com/image/3e8ca663fd65495c89c5bd062fb41b4e.png)

![Setting member](http://image.prntscr.com/image/388a11b858be410c9c772eb850ac0bc5.png)

![Change password](http://image.prntscr.com/image/391dd67c748146b6a412a92393e3d3a3.png)

![Task schedule](http://image.prntscr.com/image/448fe09bdc814b149882e50efcde249d.png)

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
