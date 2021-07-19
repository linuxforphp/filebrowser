<?php

/*
 * This file is part of the FileBrowser package.
 *
 * Copyright 2021, Foreach Code Factory <services@etista.com>
 * Copyright 2018-2021, Milos Stojanovic <alcalbg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 */

namespace Filebrowser\Services\Archiver;

use Filebrowser\Services\Storage\Filesystem;

interface ArchiverInterface
{
    public function createArchive(Filesystem $storage): string;

    public function uncompress(string $source, string $destination, Filesystem $storage);

    public function addDirectoryFromStorage(string $path);

    public function addFileFromStorage(string $path);

    public function closeArchive();

    public function storeArchive($destination, $name);
}
