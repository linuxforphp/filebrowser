<?php

/*
 * This file is part of the FileBrowser package.
 *
 * Copyright 2021, Foreach Code Factory <services@etista.com>
 * Copyright 2018-2021, Milos Stojanovic <alcalbg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 */

namespace Filebrowser\Services\Auth;

interface AuthInterface
{
    public function user(): ?User;

    public function authenticate($username, $password): bool;

    public function forget();

    public function find($username): ?User;

    public function store(User $user);

    public function update($username, User $user, $password = ''): User;

    public function add(User $user, $password): User;

    public function delete(User $user);

    public function getGuest(): User;

    public function allUsers(): UsersCollection;
}
