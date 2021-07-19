<?php

/*
 * This file is part of the FileBrowser package.
 *
 * Copyright 2021, Foreach Code Factory <services@etista.com>
 * Copyright 2018-2021, Milos Stojanovic <alcalbg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 */

namespace Filebrowser;

use Filebrowser\Config\Config;
use Filebrowser\Container\Container;
use Filebrowser\Kernel\Request;
use Filebrowser\Kernel\Response;
use Filebrowser\Kernel\StreamedResponse;

class App
{
    private $container;

    public function __construct(Config $config, Request $request, Response $response, StreamedResponse $sresponse, Container $container)
    {
        $container->set(Config::class, $config);
        $container->set(Container::class, $container);
        $container->set(Request::class, $request);
        $container->set(Response::class, $response);
        $container->set(StreamedResponse::class, $sresponse);

        foreach ($config->get('services', []) as $key => $service) {
            $container->set($key, $container->get($service['handler']));
            $container->get($key)->init(isset($service['config']) ? $service['config'] : []);
        }

        $response->send();

        $this->container = $container;
    }

    public function resolve($name)
    {
        return $this->container->get($name);
    }
}
