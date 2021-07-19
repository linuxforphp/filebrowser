<?php

/*
 * This file is part of the FileGator package.
 *
 * Copyright 2021, Foreach Code Factory <services@linuxforphp.com>
 * Copyright 2018-2021, Milos Stojanovic <alcalbg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (version_compare(PHP_VERSION, '7.2.5', '<')) {
    echo 'Minimum requirement is PHP 7.2.5 You are using: '.PHP_VERSION."\n";
    die;
}

if (! is_writable(__DIR__.'/../private/logs/')) {
    echo 'Folder not writable: /private/logs/'."\n";
    die;
}

if (! is_writable(__DIR__.'/../repository/')) {
    echo 'Folder not writable: /repository/'."\n";
    die;
}

if (! file_exists(__DIR__.'/../configuration.php')) {
    copy(__DIR__.'/../configuration_sample.php', __DIR__.'/../configuration.php');
}

require __DIR__.'/../vendor/autoload.php';

if (! defined('APP_ENV')) {
    define('APP_ENV', 'production');
}

if (! defined('APP_PUBLIC_PATH')) {
    define('APP_PUBLIC_PATH', '');
}

define('APP_PUBLIC_DIR', __DIR__);
define('APP_VERSION', '7.6.0');

use Filebrowser\App;
use Filebrowser\Config\Config;
use Filebrowser\Container\Container;
use Filebrowser\Kernel\Request;
use Filebrowser\Kernel\Response;
use Filebrowser\Kernel\StreamedResponse;

$config = require __DIR__.'/../configuration.php';

new App(new Config($config), Request::createFromGlobals(), new Response(), new StreamedResponse(), new Container());
