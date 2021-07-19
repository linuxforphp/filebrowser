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

use Filebrowser\Container\Container;
use Filebrowser\Kernel\Request;
use Filebrowser\Services\Auth\User;
use Filebrowser\Services\Router\Router;
use Tests\MockUsers;
use Tests\TestCase;

/**
 * @internal
 */
class RouterTest extends TestCase
{
    private $config_stub;

    protected function setUp(): void
    {
        $this->config_stub = [
            'query_param' => 'r',
            'routes_file' => __DIR__.'/../../config/testroutes.php',
            'routes_optional_file' => __DIR__.'/../../config/testroutesoptional.php',
            'fastzip'=> false
        ];

        parent::setUp();
    }

    public function testHome()
    {
        $request = Request::create('?r=/', 'GET');

        $user = new User();

        $container = $this->createMock(Container::class);
        $container->expects($this->once())
            ->method('call')
            ->with(['\Filebrowser\Controllers\ViewController', 'index'], [])
        ;

        $this->getRouter($request, $user, $container);
    }

    public function testPostToLogin()
    {
        $request = Request::create('?r=/login', 'POST');

        $user = new User();

        $container = $this->createMock(Container::class);
        $container->expects($this->once())
            ->method('call')
            ->with(['\Filebrowser\Controllers\AuthController', 'login'], [])
        ;

        $this->getRouter($request, $user, $container);
    }

    public function testRouteNotFound()
    {
        $request = Request::create('?r=/something', 'POST');

        $user = new User();

        $container = $this->createMock(Container::class);
        $container->expects($this->once())
            ->method('call')
            ->with(['\Filebrowser\Controllers\ErrorController', 'notFound'], [])
        ;

        $this->getRouter($request, $user, $container);
    }

    public function testMethodNotAllowed()
    {
        $request = Request::create('?r=/login', 'GET');

        $user = new User();

        $container = $this->createMock(Container::class);
        $container->expects($this->once())
            ->method('call')
            ->with(['\Filebrowser\Controllers\ErrorController', 'methodNotAllowed'], [])
        ;

        $this->getRouter($request, $user, $container);
    }

    public function testRouteIsProtectedFromGuests()
    {
        $request = Request::create('?r=/noguests', 'GET');

        $user = new User();

        $container = $this->createMock(Container::class);
        $container->expects($this->once())
            ->method('call')
            ->with(['\Filebrowser\Controllers\ErrorController', 'notFound'], [])
        ;

        $this->getRouter($request, $user, $container);
    }

    public function testRouteIsAllowedForUser()
    {
        $request = Request::create('?r=/noguests', 'GET');

        $user = new User();
        $user->setRole('user');

        $container = $this->createMock(Container::class);
        $container->expects($this->once())
            ->method('call')
            ->with(['ProtectedController', 'protectedMethod'], [])
        ;

        $this->getRouter($request, $user, $container);
    }

    public function testRouteIsProtectedFromUsers()
    {
        $request = Request::create('?r=/adminonly', 'GET');

        $user = new User();
        $user->setRole('user');

        $container = $this->createMock(Container::class);
        $container->expects($this->once())
            ->method('call')
            ->with(['\Filebrowser\Controllers\ErrorController', 'notFound'], [])
        ;

        $this->getRouter($request, $user, $container);
    }

    public function testRouteIsAllowedForAdmin()
    {
        $request = Request::create('?r=/adminonly', 'GET');

        $user = new User();
        $user->setRole('admin');

        $container = $this->createMock(Container::class);
        $container->expects($this->once())
            ->method('call')
            ->with(['AdminController', 'adminOnlyMethod'], [])
        ;

        $this->getRouter($request, $user, $container);
    }

    private function getRouter(Request $request, User $user, Container $container)
    {
        $auth_stub = $this->createMock(MockUsers::class);
        $auth_stub->method('user')
            ->willReturn($user)
        ;

        $router = new Router($request, $auth_stub, $container);
        $router->init($this->config_stub);

        return $router;
    }
}
