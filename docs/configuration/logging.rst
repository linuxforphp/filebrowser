.. _LoggingAnchor:

=======
Logging
=======

.. index:: Logging

-------------------------------
Configuring the Logging Service
-------------------------------

.. index:: Logging configuration

Logging is provided trough the powerful
`Monolog <https://github.com/Seldaek/monolog>`__ library. Please read
their documentation for more details: https://github.com/Seldaek/monolog.

The default handler will simply use the ``private/logs/app.log`` file to store
application logs and errors.

::

    'Filebrowser\Services\Logger\LoggerInterface' => [
       'handler' => '\Filebrowser\Services\Logger\Adapters\MonoLogger',
       'config' => [
           'monolog_handlers' => [
               function () {
                   return new \Monolog\Handler\StreamHandler(
                       __DIR__.'/private/logs/app.log',
                       \Monolog\Logger::DEBUG
                   );
               },
           ],
       ],
    ],

There are many different handlers you can add on top of this stack
(monolog_handlers array). Some of them are listed
`here <https://github.com/Seldaek/monolog#documentation>`__.
