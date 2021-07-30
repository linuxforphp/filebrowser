.. _AuthenticationAnchor:

==============
Authentication
==============

.. index:: Authentication

--------------------
Default Auth Service
--------------------

.. index:: Authentication default

By default, user credentials are stored in a json file. For some use cases, this is
enough. It also makes this application lightweight since no database is
required.

The default handler only accepts a filename parameter. This file should be
writable by the web server.

::

    'Filebrowser\Services\Auth\AuthInterface' => [
       'handler' => '\Filebrowser\Services\Auth\Adapters\JsonFile',
       'config' => [
           'file' => __DIR__.'/private/users.json',
       ],
    ],

------------------------------------------
Configuring Auth Service to Use A Database
------------------------------------------

.. index:: Authentication database

You can also use a MySQL database to store your users.

First, create a table ``users`` with this sql query:

::

    CREATE TABLE `users` (
       `id` int(10) NOT NULL AUTO_INCREMENT,
       `username` varchar(255) NOT NULL,
       `name` varchar(255) NOT NULL,
       `role` varchar(20) NOT NULL,
       `permissions` varchar(200) NOT NULL,
       `homedir` varchar(2000) NOT NULL,
       `password` varchar(255) NOT NULL,
       PRIMARY KEY (`id`),
       KEY `username` (`username`)
    ) CHARSET=utf8 COLLATE=utf8_bin;

Then, import default users with sql query:

::

    INSERT INTO `users` (`username`, `name`, `role`, `permissions`, `homedir`, `password`)
    VALUES
    ('guest', 'Guest', 'guest', '', '/', ''),
    ('admin', 'Admin', 'admin', 'read|write|upload|download|batchdownload|zip', '/', '$2y$10$Nu35w4pteLfc7BDCIkDPkecjw8wsH8Y2GMfIewUbXLT7zzW6WOxwq');

At the end, open ``configuration.php``, and update the AuthInterface handler
with your database settings:

::

    'Filebrowser\Services\Auth\AuthInterface' => [
       'handler' => '\Filebrowser\Services\Auth\Adapters\Database',
       'config' => [
           'driver' => 'mysqli',
           'host' => 'localhost',
           'username' => 'root',
           'password' => 'password',
           'database' => 'filebrowser',
       ],
    ],

-----------------------------------------
Configuring Auth Service to Use WordPress
-----------------------------------------

.. index:: Authentication with WordPress

Replace your current Auth handler in ``configuration.php`` file, like
so:

::

    'Filebrowser\Services\Auth\AuthInterface' => [
       'handler' => '\Filebrowser\Services\Auth\Adapters\WPAuth',
       'config' => [
           'wp_dir' => '/var/www/my_wordpress_site/',
           'permissions' => ['read', 'write', 'upload', 'download', 'batchdownload', 'zip'],
           'private_repos' => false,
       ],
    ],

You can then adjust the following configuration elements:

- ``wp_dir`` should be the directory path of your wordpress installation,
- ``permissions`` is the array of permissions given to each user,
- ``private_repos`` must be set to true or false, in order to allow, or not, each user to have his own home folder.

With more recent versions of the FileBrowser you can set ``guest_redirection`` in your ``configuration.php`` to redirect logged out users back to your WordPress site, like so:

::

    'frontend_config' => [
     ...
       'guest_redirection' => 'http://example.com/wp-admin/',
     ...
    ]

------------------------------------
Configuring Auth Service to Use LDAP
------------------------------------

.. index:: Authentication with LDAP

Replace your current Auth handler in ``configuration.php`` file, like so:

::

    'Filebrowser\Services\Auth\AuthInterface' => [
       'handler' => '\Filebrowser\Services\Auth\Adapters\LDAP',
       'config' => [
               'private_repos' => false,
               'ldap_server'=>'ldap://192.168.1.1',
               'ldap_bindDN'=>'uid=ldapbinduser,cn=users,dc=ldap,dc=example,dc=com',
               'ldap_bindPass'=>'ldapbinduser-password',
               'ldap_baseDN'=>'cn=users,dc=ldap,dc=example,dc=com',
               'ldap_filter'=>'(uid=*)', //ex: 'ldap_filter'=>'(&(uid=*)(memberOf=cn=administrators,cn=groups,dc=ldap,dc=example,dc=com))',
               'ldap_attributes' => ["uid","cn","dn"],
               'ldap_userFieldMapping'=> [
                   'username' =>'uid',
                   'name' =>'cn',
                   'userDN' =>'dn',
                   'default_permissions' => 'read|write|upload|download|batchdownload|zip',
                   'admin_usernames' =>['user1', 'user2'],
               ],
       ],
    ],

------------------------------------------------
Custom Authentication Using Third-Party Software
------------------------------------------------

.. index:: Authentication customization

If you want to use FileBrowser as a part of another application, you
probably already have users stored somewhere else. What you need in this
case is to build a new custom Auth adapter that matches the
`AuthInterface <https://github.com/linuxforphp/filebrowser/blob/master/backend/Services/Auth/AuthInterface.php>`__
to connect the applications together. This new adapter will allow the FileBrowser
tp try to authenticate users with the other application, and then translate each new user
into one of its `User <https://github.com/linuxforphp/filebrowser/blob/master/backend/Services/Auth/User.php>`__
objects.

------------------
API Authentication
------------------

.. index:: Authentication API

When using the Authentication API, FileBrowser's front end application will use session-based
authentication to authenticate users, and interact with the FileBrowser's back end handlers.

.. note:: The application will not work if you disable cookies.
