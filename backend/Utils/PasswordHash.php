<?php

/*
 * This file is part of the FileBrowser package.
 *
 * Copyright 2021, Foreach Code Factory <services@etista.com>
 * Copyright 2018-2021, Milos Stojanovic <alcalbg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 */

namespace Filebrowser\Utils;

/**
 * @codeCoverageIgnore
 */
trait PasswordHash
{
    public static function hashPassword($value)
    {
        $hash = password_hash($value, PASSWORD_BCRYPT);

        if ($hash === false) {
            throw new \Exception('Bcrypt hashing not supported.');
        }

        return $hash;
    }

    public static function verifyPassword($value, $hash)
    {
        return password_verify($value, $hash);
    }
}
