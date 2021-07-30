.. _RouterAnchor:

======
Router
======

.. index:: Router

--------------
Router Service
--------------

The Router service is the well-known
`FastRoute <https://github.com/nikic/FastRoute>`__ library. There is no
need to change this service unless you’re extending the script.

The router uses the unique query parameter ``?r=`` to pass route information
to other application components. Because of this feature, this (single-page)
application does not require rewrite rules in the .htaccess file, or similar modifications.

Example routes:

-  ``http://example.com/?r=/some/route&param1=val1&param2=val2``
-  ``http://example.com/?r=/user/{user_id}&param1=val1``

-----------
Routes File
-----------

.. index:: Routes file

The Routes files are located in the ``config/`` folder. There are two main files
that will configure routes: ``config/routes.config.php`` and
``config/routes.optional.config.php``. Each route is defined like so:

::

    [
       'route' => [
           'GET', '/download/{path_encoded}', '\Filebrowser\Controllers\DownloadController@download',
       ],
       'roles' => [
           'guest', 'user', 'admin',
       ],
       'permissions' => [
           'download',
       ],
    ],

As you can see in this example, you can assign required user roles and
permissions for each route.

-----------
Controllers
-----------

.. index:: Controllers

Since FileBrowser is using an awesome dependency injection
`container <https://github.com/PHP-DI/PHP-DI>`__, you can type hint
dependencies directly in the definition of a controller's action methods.

You can also mix route parameters and dependencies in any order, like in
this example:

::

    public function __construct(Config $config, Session $session, AuthInterface $auth, Filesystem $storage)
    {
     // ...
    }

    public function download($path_encoded, Request $request, Response $response, StreamedResponse $streamedResponse)
    {
     // ...
    }
