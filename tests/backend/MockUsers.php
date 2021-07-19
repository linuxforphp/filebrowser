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

use Filebrowser\Services\Auth\Adapters\JsonFile;
use Filebrowser\Services\Auth\AuthInterface;
use Filebrowser\Services\Auth\User;
use Filebrowser\Services\Service;

class MockUsers extends JsonFile implements Service, AuthInterface
{
    private $users_array = [];

    public function init(array $config = [])
    {
        $this->addMockUsers();
    }

    protected function getUsers(): array
    {
        return $this->users_array;
    }

    protected function saveUsers(array $users)
    {
        return $this->users_array = $users;
    }

    public function user(): ?User
    {
        return $this->session ? $this->session->get(self::SESSION_KEY, null) : null;
    }


    private function addMockUsers()
    {
        $guest = new User();
        $guest->setRole('guest');
        $guest->setHomedir('/');
        $guest->setUsername('guest');
        $guest->setName('Guest');
        $guest->setPermissions([]);

        $admin = new User();
        $admin->setRole('admin');
        $admin->setHomedir('/');
        $admin->setUsername('admin@example.com');
        $admin->setName('Admin');
        $admin->setPermissions(['read', 'write', 'upload', 'download', 'batchdownload', 'zip']);

        $john = new User();
        $john->setRole('user');
        $john->setHomedir('/john');
        $john->setUsername('john@example.com');
        $john->setName('John Doe');
        $john->setPermissions(['read', 'write', 'upload', 'download', 'batchdownload']);

        $jane = new User();
        $jane->setRole('user');
        $jane->setHomedir('/jane');
        $jane->setUsername('jane@example.com');
        $jane->setName('Jane Doe');
        $jane->setPermissions(['read', 'write']);

        $this->add($guest, '');
        $this->add($admin, 'admin123');
        $this->add($john, 'john123');
        $this->add($jane, 'jane123');
    }

}
