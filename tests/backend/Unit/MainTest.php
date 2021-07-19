<?php

/*
 * This file is part of the FileBrowser package.
 *
 * Copyright 2021, Foreach Code Factory <services@etista.com>
 * Copyright 2018-2021, Milos Stojanovic <alcalbg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 */

namespace Tests\Unit;

use Filebrowser\App;
use Filebrowser\Config\Config;
use Filebrowser\Container\Container;
use Filebrowser\Kernel\Request;
use Filebrowser\Kernel\Response;
use Tests\FakeResponse;
use Tests\FakeStreamedResponse;
use Tests\TestCase;

/**
 * @internal
 */
class MainTest extends TestCase
{
    public function testMainApp()
    {
        $config = new Config();
        $request = new Request();
        $response = new FakeResponse();
        $sresponse = new FakeStreamedResponse();
        $container = new Container();

        $app = new App($config, $request, $response, $sresponse, $container);

        $this->assertEquals($config, $app->resolve(Config::class));
        $this->assertEquals($request, $app->resolve(Request::class));
        $this->assertInstanceOf(Response::class, $app->resolve(Response::class));
    }
}
