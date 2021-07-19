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

if (! defined('DIR_SEP')) {
    define('DIR_SEP', DIRECTORY_SEPARATOR);
}

if (! defined('APP_ENV')) {
    define('APP_ENV', 'production');
}

if (! defined('APP_PUBLIC_PATH')) {
    define('APP_PUBLIC_PATH', '');
}

if (! defined('APP_PUBLIC_DIR')) {
    define('APP_PUBLIC_DIR', __DIR__);
}

if (! defined('APP_ROOT_DIR')) {
    define('APP_ROOT_DIR', dirname(__DIR__));
}

if (! defined('APP_VERSION')) {
    define('APP_VERSION', '7.6.0');
}

if (version_compare(PHP_VERSION, '7.2.5', '<')) {
    die('Minimum requirement is PHP 7.2.5 You are using: ' . PHP_VERSION);
}

if (! is_writable(APP_ROOT_DIR . DIR_SEP . 'private' . DIR_SEP . 'logs')) {
    die('Folder not writable: /private/logs/');
}

if (! is_writable(APP_ROOT_DIR . DIR_SEP .  'repository/')) {
    die('Folder not writable: /repository/');
}

if (! file_exists(APP_ROOT_DIR . DIR_SEP .  'configuration.php')) {
    copy(APP_ROOT_DIR . DIR_SEP .  'configuration_sample.php', APP_ROOT_DIR . DIR_SEP . 'configuration.php');
}

require APP_ROOT_DIR . DIR_SEP . 'vendor' . DIR_SEP . 'autoload.php';

use Filebrowser\App;
use Filebrowser\Config\Config;
use Filebrowser\Container\Container;
use Filebrowser\Kernel\Request;
use Filebrowser\Kernel\Response;
use Filebrowser\Kernel\StreamedResponse;

$baseConfig = require APP_ROOT_DIR . DIR_SEP . 'configuration.php';
$servicesConfig = require APP_ROOT_DIR . DIR_SEP . 'config' . DIR_SEP . 'services.config.php';

$config = new Config(
    array_merge(
        $baseConfig,
        $servicesConfig
    )
);

new App($config, Request::createFromGlobals(), new Response(), new StreamedResponse(), new Container());
