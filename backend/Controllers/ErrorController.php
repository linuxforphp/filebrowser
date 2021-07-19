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

class ErrorController
{
    protected $request_type;

    public function __construct(Request $request)
    {
        $this->request_type = $request->getContentType();
    }

    public function notFound(Response $response)
    {
        return $this->request_type == 'json' ? $response->json('Not Found', 404) : $response->html('Not Found', 404);
    }

    public function methodNotAllowed(Response $response)
    {
        return $this->request_type == 'json' ? $response->json('Not Allowed', 401) : $response->html('Not Found', 401);
    }
}
