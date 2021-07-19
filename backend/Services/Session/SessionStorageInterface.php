<?php

/*
 * This file is part of the FileBrowser package.
 *
 * Copyright 2021, Foreach Code Factory <services@etista.com>
 * Copyright 2018-2021, Milos Stojanovic <alcalbg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 */

namespace Filebrowser\Services\Session;

interface SessionStorageInterface
{
    public function set(string $key, $data);

    public function get(string $key, $default = null);

    public function invalidate();

    public function save();
}
