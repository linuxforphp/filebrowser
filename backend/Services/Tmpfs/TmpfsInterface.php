<?php

/*
 * This file is part of the FileBrowser package.
 *
 * Copyright 2021, Foreach Code Factory <services@etista.com>
 * Copyright 2018-2021, Milos Stojanovic <alcalbg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 */

namespace Filebrowser\Services\Tmpfs;

interface TmpfsInterface
{
    public function exists(string $filename): bool;

    public function findAll($pattern): array;

    public function write(string $filename, $data, $append);

    public function read(string $filename): string;

    public function readStream(string $filename): array;

    public function remove(string $filename);

    public function getFileLocation(string $filename): string;

    public function clean(int $older_than);
}
