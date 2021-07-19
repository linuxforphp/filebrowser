<?php

/*
 * This file is part of the FileBrowser package.
 *
 * Copyright 2021, Foreach Code Factory <services@etista.com>
 * Copyright 2018-2021, Milos Stojanovic <alcalbg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 */

namespace Filebrowser\Controllers;

use Filebrowser\Config\Config;
use Filebrowser\Kernel\Response;
use Filebrowser\Services\View\ViewInterface;

class ViewController
{
    public function index(Response $response, ViewInterface $view)
    {
        return $response->html($view->getIndexPage());
    }

    public function getFrontendConfig(Response $response, Config $config)
    {
        return $response->json($config->get('frontend_config'));
    }
}
