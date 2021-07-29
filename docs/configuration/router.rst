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

The router uses unique query parameter ``?r=`` to pass the route info.
Because of this feature, this (single-page) application does not require
rewrite rules, .htaccess or similar tweaks.

Example routes:

-  ``http://example.com/?r=/some/route&param1=val1&param2=val2``
-  ``http://example.com/?r=/user/{user_id}&param1=val1``

-----------
Routes File
-----------

.. index:: Routes file

Routes file is located here ``config/routes.config.php`` Each
route in the routes array looks like this:

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

As you can see in the example, you can assign required user roles and
permissions for each route.

-----------
Controllers
-----------

.. index:: Controllers

Since FileBrowser is using an awesome dependency injection
`container <https://github.com/PHP-DI/PHP-DI>`__ you can type-hint
dependencies directly in your controllers.

You can also mix route parameters and dependencies in any order like in
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
