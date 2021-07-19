<?php

/*
 * This file is part of the FileBrowser package.
 *
 * Copyright 2021, Foreach Code Factory <services@etista.com>
 * Copyright 2018-2021, Milos Stojanovic <alcalbg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 */

namespace Filebrowser\Services\View\Adapters;

use Filebrowser\Config\Config;
use Filebrowser\Services\Service;
use Filebrowser\Services\View\ViewInterface;

class Vuejs implements Service, ViewInterface
{
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function init(array $config = [])
    {
        $this->add_to_head = isset($config['add_to_head']) ? $config['add_to_head'] : '';
        $this->add_to_body = isset($config['add_to_body']) ? $config['add_to_body'] : '';
    }

    public function getIndexPage()
    {
        $title = $this->config->get('frontend_config.app_name');
        $public_path = $this->config->get('public_path');
        $public_dir = $this->config->get('public_dir');

        return '<!DOCTYPE html>
<html lang=en>
  <head>
    <meta charset=utf-8>
    <meta http-equiv=X-UA-Compatible content="IE=edge">
    <meta name=viewport content="width=device-width,initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>'.$title.'</title>
    '.$this->add_to_head.'
    <link href="'.$public_path.'css/app.css?'.@filemtime($public_dir.'/css/app.css').'" rel=stylesheet>
    <link href="'.$public_path.'css/chunk-vendors.css?'.@filemtime($public_dir.'/css/chunk-vendors.css').'" rel=stylesheet>
  </head>
  <body>
    <noscript><strong>Please enable JavaScript to continue.</strong></noscript>
    <div id=app></div>
    <script src="'.$public_path.'js/app.js?'.@filemtime($public_dir.'/js/app.js').'"></script>
    <script src="'.$public_path.'js/chunk-vendors.js?'.@filemtime($public_dir.'/js/chunk-vendors.js').'"></script>

    '.$this->add_to_body.'
  </body>
</html>
';
    }
}
