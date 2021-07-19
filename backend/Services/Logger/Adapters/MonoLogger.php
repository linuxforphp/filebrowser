<?php

/*
 * This file is part of the FileBrowser package.
 *
 * Copyright 2021, Foreach Code Factory <services@etista.com>
 * Copyright 2018-2021, Milos Stojanovic <alcalbg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 */

namespace Filebrowser\Services\Logger\Adapters;

use Filebrowser\Services\Logger\LoggerInterface;
use Filebrowser\Services\Service;
use Monolog\ErrorHandler;
use Monolog\Logger;

class MonoLogger implements Service, LoggerInterface
{
    protected $logger;

    public function init(array $config = [])
    {
        $this->logger = new Logger('default');

        foreach ($config['monolog_handlers'] as $handler) {
            $this->logger->pushHandler($handler());
        }

        $handler = new ErrorHandler($this->logger);
        $handler->registerErrorHandler([], true);
        $handler->registerFatalHandler();
    }

    public function log(string $message, int $level = Logger::INFO)
    {
        $this->logger->log($level, $message);
    }
}
