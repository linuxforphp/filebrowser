.. _SessionsAnchor:

========
Sessions
========

.. index:: Sessions

-----------------------
Default Session Handler
-----------------------

.. index:: Session default handler

Session handling is provided through Symfony’s
`HttpFoundation <https://symfony.com/doc/4.4/components/http_foundation.html>`__
component. Please check their documentation for more details:
https://symfony.com/doc/4.4/components/http_foundation.html.

The default session handler will use PHP’s built-in file storage. You can
also specify your own ``$save_path`` to store the session files.

::

    'Filebrowser\Services\Session\SessionStorageInterface' => [
       'handler' => '\Filebrowser\Services\Session\Adapters\SessionStorage',
       'config' => [
           'handler' => function () {
               $save_path = null; // use default system path
               //$save_path = __DIR__.'/private/sessions';
               $handler = new \Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler($save_path);

               return new \Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage([], $handler);
           },
       ],
    ],

-------------------------------------------------
Configuring the Session Service to Use a Database
-------------------------------------------------

.. index:: Session handler with databases

First, create a table ``sessions`` with this SQL:

::

    CREATE TABLE `sessions` (
         `sess_id` varbinary(128) NOT NULL,
         `sess_data` blob NOT NULL,
         `sess_lifetime` mediumint(9) NOT NULL,
         `sess_time` int(10) unsigned NOT NULL,
         PRIMARY KEY (`sess_id`)
    ) CHARSET=utf8 COLLATE=utf8_bin;

Then, open ``configuration.php``, and update the Session handler to:

::

    'Filebrowser\Services\Session\SessionStorageInterface' => [
       'handler' => '\Filebrowser\Services\Session\Adapters\SessionStorage',
       'config' => [
           'handler' => function () {
               $handler = new \Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler(
                       'mysql://root:password@localhost:3306/filebrowser'
                       );

               return new \Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage([], $handler);
           },
       ],
    ],

Don’t forget to enter the correct database credentials.

----------------------------------------
Configuring Session Service to Use Redis
----------------------------------------

.. index:: Session handler with Redis

You must require the additional `predis <https://github.com/nrk/predis/>`__
library ``composer require predis/predis`` in order to use this session handler.
Then, please modify the ``configuration.php`` file, like so:

::

    'Filebrowser\Services\Session\SessionStorageInterface' => [
       'handler' => '\Filebrowser\Services\Session\Adapters\SessionStorage',
       'config' => [
           'handler' => function () {
               $predis = new \Predis\Client('tcp://127.0.0.1:6379');
               $handler = new \Symfony\Component\HttpFoundation\Session\Storage\Handler\RedisSessionHandler($predis);

               return new \Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage([], $handler);
           },
       ],
    ],

---------------
Session Options
---------------

.. index:: Session options

The underying `session
component <https://github.com/symfony/symfony/blob/4.4/src/Symfony/Component/HttpFoundation/Session/Storage/NativeSessionStorage.php>`__
accepts array of options. For example, you can pass the ``cookie_lifetime``
parameter to extend the default session lifetime:

::

    'Filebrowser\Services\Session\SessionStorageInterface' => [
       'handler' => '\Filebrowser\Services\Session\Adapters\SessionStorage',
       'config' => [
           'handler' => function () {
               $handler = new \Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler(
                       'mysql://root:password@localhost:3306/filebrowser'
                       );

               return new \Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage([
                       'cookie_lifetime' => 365 * 24 * 60 * 60, // one year
               ], $handler);
           },
       ],
    ],
