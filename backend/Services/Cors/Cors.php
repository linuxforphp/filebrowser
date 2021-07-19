<?php

/*
 * This file is part of the FileBrowser package.
 *
 * Copyright 2021, Foreach Code Factory <services@etista.com>
 * Copyright 2018-2021, Milos Stojanovic <alcalbg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 */

namespace Filebrowser\Services\Cors;

use Filebrowser\Kernel\Request;
use Filebrowser\Kernel\Response;
use Filebrowser\Services\Service;

/**
 * @codeCoverageIgnore
 */
class Cors implements Service
{
    protected $request;

    protected $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function init(array $config = [])
    {
        if ($config['enabled'] !== true) {
            return;
        }

        $this->response->headers->set('Access-Control-Allow-Origin', $this->request->headers->get('Origin'));
        $this->response->headers->set('Access-Control-Allow-Credentials', 'true');
        $this->response->headers->set('Access-Control-Expose-Headers', 'x-csrf-token');

        if ($this->request->server->get('REQUEST_METHOD') == 'OPTIONS') {
            $this->response->headers->set('Access-Control-Allow-Headers', 'content-type, x-csrf-token');
            $this->response->send();
            die;
        }
    }
}
