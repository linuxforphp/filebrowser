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
use Filebrowser\Kernel\Request;
use Filebrowser\Kernel\Response;
use Filebrowser\Services\Archiver\ArchiverInterface;
use Filebrowser\Services\Auth\AuthInterface;
use Filebrowser\Services\Process\SymfonyProcessFactory;
use Filebrowser\Services\Session\SessionStorageInterface as Session;
use Filebrowser\Services\Storage\Filesystem;

class FileController
{
    const SESSION_CWD = 'current_path';

    protected $session;

    protected $auth;

    protected $config;

    protected $storage;

    protected $separator;

    public function __construct(Config $config, Session $session, AuthInterface $auth, Filesystem $storage)
    {
        $this->session = $session;
        $this->config = $config;
        $this->auth = $auth;

        $user = $this->auth->user() ?: $this->auth->getGuest();

        $this->storage = $storage;
        $this->storage->setPathPrefix($user->getHomeDir());

        $this->separator = $this->storage->getSeparator();
    }

    public function changeDirectory(Request $request, Response $response)
    {
        $path = $request->input('to', $this->separator);

        $this->session->set(self::SESSION_CWD, $path);

        return $response->json($this->storage->getDirectoryCollection($path));
    }

    public function getDirectory(Request $request, Response $response)
    {
        $path = $request->input('dir', $this->session->get(self::SESSION_CWD, $this->separator));

        $content = $this->storage->getDirectoryCollection($path);

        return $response->json($content);
    }

    public function createNew(Request $request, Response $response)
    {
        $type = $request->input('type', 'file');
        $name = $request->input('name');
        $path = $this->session->get(self::SESSION_CWD, $this->separator);

        if ($type == 'dir') {
            $this->storage->createDir($path, $request->input('name'));
        }
        if ($type == 'file') {
            $this->storage->createFile($path, $request->input('name'));
        }

        return $response->json('Done');
    }

    public function copyItems(Request $request, Response $response)
    {
        $items = $request->input('items', []);
        $destination = $request->input('destination', $this->separator);

        foreach ($items as $item) {
            if ($item->type == 'dir') {
                $this->storage->copyDir($item->path, $destination);
            }
            if ($item->type == 'file') {
                $this->storage->copyFile($item->path, $destination);
            }
        }

        return $response->json('Done');
    }

    public function moveItems(Request $request, Response $response)
    {
        $items = $request->input('items', []);
        $destination = $request->input('destination', $this->separator);

        foreach ($items as $item) {
            $full_destination = trim($destination, $this->separator)
                    .$this->separator
                    .ltrim($item->name, $this->separator);
            $this->storage->move($item->path, $full_destination);
        }

        return $response->json('Done');
    }

    public function zipItems(Request $request, Response $response, ArchiverInterface $archiver)
    {
        $items = $request->input('items', []);
        $destination = $request->input('destination', $this->separator);
        $name = $request->input('name', $this->config->get('frontend_config.default_archive_name'));

        $archiver->createArchive($this->storage);

        foreach ($items as $item) {
            if ($item->type == 'dir') {
                $archiver->addDirectoryFromStorage($item->path);
            }
            if ($item->type == 'file') {
                $archiver->addFileFromStorage($item->path);
            }
        }

        $archiver->storeArchive($destination, $name);

        return $response->json('Done');
    }

    public function unzipItem(Request $request, Response $response, ArchiverInterface $archiver)
    {
        $source = $request->input('item');
        $destination = $request->input('destination', $this->separator);

        $archiver->uncompress($source, $destination, $this->storage);

        return $response->json('Done');
    }

    public function zipItemsProc(Request $request, Response $response, SymfonyProcessFactory $serviceFactory)
    {
        $pathPrefix = REPOSITORY_ROOT;
        $pathPrefix .= $this->storage->getPathPrefix() === '/' ? '' : $this->storage->getPathPrefix();

        $items = $request->input('items', []);
        $destination = $request->input('destination', $this->separator);
        $destination = $destination === '/' ? $destination : $destination . DIR_SEP;
        $name = $request->input('name', $this->config->get('frontend_config.default_archive_name'));

        $command[] = '/usr/bin/zip';
        $command[] = '-r';
        $command[] = $pathPrefix . $destination . $name;

        foreach ($items as $item) {
            $command[] = substr($item->path, 1, strlen($item->path));
        }

        $archiverProcess = $serviceFactory->createService($command);

        $archiverProcess->setWorkingDirectory($pathPrefix);

        $archiverProcess->start();

        while ($archiverProcess->isRunning()) {
            // waiting for process to finish
        }

        // executes after the command finishes
        if (!$archiverProcess->isSuccessful()) {
            //throw new ProcessFailedException($process);
            return $response->json('Could not create the zip file');
        }

        return $response->json('Done');
    }

    public function unzipItemProc(Request $request, Response $response, SymfonyProcessFactory $serviceFactory)
    {
        $pathPrefix = REPOSITORY_ROOT;
        $pathPrefix .= $this->storage->getPathPrefix() === '/' ? '' : $this->storage->getPathPrefix();

        $source = $request->input('item');
        $destination = $request->input('destination', $this->separator);

        $command[] = '/usr/bin/unzip';
        $command[] = $pathPrefix . $source;
        $command[] = '-d';
        $command[] = $pathPrefix . $destination;

        $archiverProcess = $serviceFactory->createService($command);

        $archiverProcess->start();

        while ($archiverProcess->isRunning()) {
            // waiting for process to finish
        }

        // executes after the command finishes
        if (!$archiverProcess->isSuccessful()) {
            //throw new ProcessFailedException($process);
            return $response->json('Could not unzip the file');
        }

        return $response->json('Done');
    }

    public function renameItem(Request $request, Response $response)
    {
        $destination = $request->input('destination', $this->separator);
        $from = $request->input('from');
        $to = $request->input('to');

        $this->storage->rename($destination, $from, $to);

        return $response->json('Done');
    }

    public function deleteItems(Request $request, Response $response)
    {
        $items = $request->input('items', []);

        foreach ($items as $item) {
            if ($item->type == 'dir') {
                $this->storage->deleteDir($item->path);
            }
            if ($item->type == 'file') {
                $this->storage->deleteFile($item->path);
            }
        }

        return $response->json('Done');
    }

    public function saveContent(Request $request, Response $response)
    {
        $path = $request->input('dir', $this->session->get(self::SESSION_CWD, $this->separator));

        $name = $request->input('name');
        $content = $request->input('content');

        $stream = tmpfile();
        fwrite($stream, $content);
        rewind($stream);

        $this->storage->deleteFile($path.$this->separator.$name);
        $this->storage->store($path, $name, $stream);

        if (is_resource($stream)) {
            fclose($stream);
        }

        return $response->json('Done');
    }
}
