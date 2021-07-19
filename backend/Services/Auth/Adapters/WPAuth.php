<?php

/*
 * This file is part of the FileBrowser package.
 *
 * Copyright 2021, Foreach Code Factory <services@etista.com>
 * Copyright 2018-2021, Milos Stojanovic <alcalbg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 */

namespace Filebrowser\Services\Auth\Adapters;

use Filebrowser\Services\Auth\AuthInterface;
use Filebrowser\Services\Auth\User;
use Filebrowser\Services\Auth\UsersCollection;
use Filebrowser\Services\Service;

/**
 * @codeCoverageIgnore
 */
class WPAuth implements Service, AuthInterface
{

    protected $permissions = [];

    protected $private_repos = false;

    public function init(array $config = [])
    {
        define('WP_USE_THEMES', false);
        require_once(rtrim($config['wp_dir'], '/').'/wp-blog-header.php');

        $this->permissions = isset($config['permissions']) ? (array)$config['permissions'] : [];
        $this->private_repos = isset($config['private_repos']) ? (bool)$config['private_repos'] : false;
    }

    public function user(): ?User
    {
        $wpuser = wp_get_current_user();

        if ($wpuser->exists()) {
            return $this->transformUser($wpuser);
        }

        return $this->getGuest();
    }

    public function transformUser($wpuser): User
    {
        $user = new User();
        $user->setUsername($wpuser->data->user_login);
        $user->setName($wpuser->data->display_name);
        $user->setRole('user');
        $user->setPermissions($this->permissions);
        $user->setHomedir('/');

        // private repositories for each user?
        if ($this->private_repos) {
            $user->setHomedir('/'.$wpuser->data->user_login);
        }

        // ...but not for wp admins
        if (in_array('administrator', (array)$wpuser->roles)) {
            $user->setHomedir('/');
        }

        return $user;
    }

    public function authenticate($username, $password): bool
    {
        $creds = array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => true
        );

        $wpuser = wp_signon($creds, false);

        if (!is_wp_error($wpuser)) {
            wp_set_current_user($wpuser->data->ID);
            $this->transformUser($wpuser);
            return true;
        }

        return false;
    }

    public function forget()
    {
        wp_logout();
    }

    public function store(User $user)
    {
        return null; // not used
    }

    public function update($username, User $user, $password = ''): User
    {
        if ($password && get_current_user_id()) {
            wp_set_password($password, get_current_user_id());
        }
        return new User(); // not used
    }

    public function add(User $user, $password): User
    {
        return new User(); // not used
    }

    public function delete(User $user)
    {
        return true; // not used
    }

    public function find($username): ?User
    {
        return null; // not used
    }

    public function allUsers(): UsersCollection
    {
        return new UsersCollection(); // not used
    }

    public function getGuest(): User
    {
        $guest = new User();

        $guest->setUsername('guest');
        $guest->setName('Guest');
        $guest->setRole('guest');
        $guest->setHomedir('/');
        $guest->setPermissions([]);

        return $guest;
    }

}
