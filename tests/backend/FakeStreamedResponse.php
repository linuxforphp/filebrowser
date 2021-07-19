<?php

/*
 * This file is part of the FileBrowser package.
 *
 * Copyright 2021, Foreach Code Factory <services@etista.com>
 * Copyright 2018-2021, Milos Stojanovic <alcalbg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 */

namespace Tests;

use Filebrowser\Kernel\StreamedResponse;

class FakeStreamedResponse extends StreamedResponse
{
    public function send()
    {
        // do nothing
    }
}
