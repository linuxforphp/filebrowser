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

use Filebrowser\Kernel\Request;
use Filebrowser\Kernel\Response;
use Filebrowser\Services\Auth\AuthInterface;
use Filebrowser\Services\Logger\LoggerInterface;
use Rakit\Validation\Validator;

class AuthController
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function login(Request $request, Response $response, AuthInterface $auth)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if ($auth->authenticate($username, $password)) {
            $this->logger->log("Logged in {$username} from IP ".$request->getClientIp());

            return $response->json($auth->user());
        }

        $this->logger->log("Login failed for {$username} from IP ".$request->getClientIp());

        return $response->json('Login failed, please try again', 422);
    }

    public function logout(Response $response, AuthInterface $auth)
    {
        return $response->json($auth->forget());
    }

    public function getUser(Response $response, AuthInterface $auth)
    {
        $user = $auth->user() ?: $auth->getGuest();

        return $response->json($user);
    }

    public function changePassword(Request $request, Response $response, AuthInterface $auth, Validator $validator)
    {
        $validator->setMessage('required', 'This field is required');
        $validation = $validator->validate($request->all(), [
            'oldpassword' => 'required',
            'newpassword' => 'required',
        ]);

        if ($validation->fails()) {
            $errors = $validation->errors();

            return $response->json($errors->firstOfAll(), 422);
        }

        if (! $auth->authenticate($auth->user()->getUsername(), $request->input('oldpassword'))) {
            return $response->json(['oldpassword' => 'Wrong password'], 422);
        }

        return $response->json($auth->update($auth->user()->getUsername(), $auth->user(), $request->input('newpassword')));
    }
}
