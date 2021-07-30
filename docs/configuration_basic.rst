.. _ConfigurationAnchor:

==============
Configuration
==============

.. index:: Configuration

-------------------
Basic configuration
-------------------

.. index:: Configuration basics

All services are set with fairly conservative defaults. For regular users, there
is no need to change anything. The application should work out of the box.

You can edit the ``configuration.php`` file in order to customize the application, by changing things
like the logo, the title, the language settings, and the upload permissions.

All other configuration files can be found in the ``config/`` folder.

.. note:: If you make a mistake in any of the configuration files (forgot to close a quote?), the application will fail to load, and log an error. Please use the provided default ``configuration_sample.php`` file to restore the configuration to its initial state.

::

   'frontend_config' => [
        'app_name' => 'FileBrowser',
        'app_version' => APP_VERSION,
        'language' => 'english',
        'logo' => 'https://linuxforphp.com/img/logo.svg',
        'upload_max_size' => 100 * 1024 * 1024, // 100MB
        'upload_chunk_size' => 1 * 1024 * 1024, // 1MB
        'upload_simultaneous' => 3,
        'default_archive_name' => 'archive.zip',
        'editable' => ['.txt', '.css', '.js', '.ts', '.html', '.php', '.json', '.ini', '.cnf', '.conf', '.env', '.monthly', '.weekly', '.daily', '.hourly', '.minute', '.htaccess'],
        'date_format' => 'YY/MM/DD hh:mm:ss', // see: https://momentjs.com/docs/#/displaying/format/
        'guest_redirection' => '', // useful for external auth adapters
        'search_simultaneous' => 5,
        'filter_entries' => [],
    ],

------------------
Adding Custom HTML
------------------

.. index:: Configuration customizations

.. index:: Adding a MOTD

.. index:: Page customizations

You can add additional html to the head and body like this:

::

    'Filebrowser\Services\View\ViewInterface' => [
       'handler' => '\Filebrowser\Services\View\Adapters\Vuejs',
       'config' => [
           'add_to_head' => '<meta name="author" content="something">',
           'add_to_body' => '<script src="http://example.com/analytics.js"></script>',
       ],
    ],

-----------------
Tweaking the Look
-----------------

.. index:: Change the look

.. index:: Front end changes

To change default color scheme and other options, edit
``frontend/App.vue`` When you’re done, recompile with ``npm run build``
like described in the :ref:`development` section.

::

   // Primary color
   $primary: #34B891;
   $primary-invert: findColorInvert($primary);

   $colors: (
       "primary": ($primary, $primary-invert),
       "info": ($info, $info-invert),
       "success": ($success, $success-invert),
       "warning": ($warning, $warning-invert),
       "danger": ($danger, $danger-invert),
   );

   // Links
   $link: $primary;
   $link-invert: $primary-invert;
   $link-focus-border: $primary;

   // Disable the widescreen breakpoint
   $widescreen-enabled: false;

   // Disable the fullhd breakpoint
   $fullhd-enabled: false;
