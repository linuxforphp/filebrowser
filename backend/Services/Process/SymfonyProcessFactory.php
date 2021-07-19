<?php

/*
 * This file is part of the FileBrowser package.
 *
 * Copyright 2021, Foreach Code Factory <services@linuxforphp.com>
 * Copyright 2018-2021, Milos Stojanovic <alcalbg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 */

namespace Filebrowser\Services\Process;

use Filebrowser\Services\ServiceFactory;
use Symfony\Component\Process\Process;

class SymfonyProcessFactory implements ServiceFactory
{
    protected $config;

    public function init(array $config = [])
    {
        $this->config = $config;
    }

    public function createService(array $params)
    {
        return new Process($params);
    }
}