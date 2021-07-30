.. _DevelopmentAnchor:

===========
Development
===========

.. index:: Development

.. _development:

-------------------------------------
Project Setup for Development (Linux)
-------------------------------------

.. index:: Development setup

You must have ``git``, ``php``, ``npm``, and ``composer`` installed.

If you have `Docker` and `Linux for Composer` (https://github.com/linuxforphp/linuxforcomposer) on your computer, you can start the container with the following command:

::

    git clone https://github.com/linuxforphp/filebrowser.git
    cd filebrowser
    composer install --ignore-platform-reqs
    vendor/bin/linuxforcomposer docker:run start


When you are ready to stop the container, enter the following command:

::

    vendor/bin/linuxforcomposer docker:run stop-force

Otherwise, you can install the application manually, using the following commands:

::

   git clone https://github.com/linuxforphp/filebrowser.git
   cd filebrowser
   cp configuration_sample.php configuration.php
   chmod -R 775 private/
   chmod -R 775 repository/
   composer install --ignore-platform-reqs
   npm install
   npm run build

------------------------
Compiles and Hot Reloads
------------------------

.. index:: Compilation

The following command will launch the back end and the front end of the application
on ports 8081 and 8080 respectively:

::

    npm run serve

Once everything is ready, please visit: ``http://localhost:8080``

-------------------------------
Running Tests & Static Analysis
-------------------------------

.. index:: Testing

Testing requires xdebug, php-zip and sqlite php extensions.

::

    vendor/bin/phpunit
    vendor/bin/phpstan analyse ./backend
    npm run lint
    npm run e2e

----------
Deployment
----------

.. index:: Deployment

Set the website document root to the ``/dist`` directory. This is also known
as the ‘public’ folder.

NOTE: For security reasons, the ``/dist`` folder is the ONLY folder you want to be
exposed to the Web. Everything else should be outside of your web
root. This way, people won't be able to access any of your important files through
the Web browser.
