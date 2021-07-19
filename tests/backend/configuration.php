<?php

return [
    'auth_file' => APP_ROOT_DIR . DIR_SEP . 'private' . DIR_SEP . 'users.json',
    'routes_file' => APP_ROOT_DIR . DIR_SEP . 'config' . DIR_SEP . 'routes.config.php',
    'routes_optional_file' => APP_ROOT_DIR . DIR_SEP . 'config' . DIR_SEP . 'routes.optional.config.php',
    'public_path' => APP_PUBLIC_PATH,
    'public_dir' => APP_PUBLIC_DIR,
    'tmpfs_path' => TEST_TMP_PATH,
    'log_file' => APP_ROOT_DIR . DIR_SEP . 'private' . DIR_SEP . 'logs' . DIR_SEP . 'app.log',
    'overwrite_on_upload' => false,
    'timezone' => 'UTC', // https://www.php.net/manual/en/timezones.php
    'download_inline' => ['pdf'], // download inline in the browser, array of extensions, use * for all

    'frontend_config' => [
        'app_name' => 'FileBrowser',
        'app_version' => APP_VERSION,
        'language' => 'english',
        'logo' => 'https://linuxforphp.com/img/logo.svg',
        'upload_max_size' => 2 * 1024 * 1024, // 1MB
        'upload_chunk_size' => 1 * 1024 * 1024, // 1MB
        'upload_simultaneous' => 3,
        'default_archive_name' => 'archive.zip',
        'editable' => ['.txt', '.css', '.js', '.ts', '.html', '.php', '.json', '.md'],
        'date_format' => 'YY/MM/DD hh:mm:ss', // see: https://momentjs.com/docs/#/displaying/format/
        'guest_redirection' => '', // useful for external auth adapters
        'search_simultaneous' => 5,
        'filter_entries' => [],
    ],

    // Choose one of the following
    'storage' => [
        'driver' => [
            'type' => 'local', //local filesystem
            'config' => [
                'separator' => '/',
                'config' => [],
                'adapter' => function () {
                    return new \League\Flysystem\Adapter\Local(
                        REPOSITORY_ROOT
                    );
                },
            ],
            'fastzip' => false // LOCAL ONLY! If true, it will override the \League\Flysystem\Adapter\Local adapter, and use the zip and unzip binaries directly.
        ],
    ],

    'services' => [
        'Filebrowser\Services\Logger\LoggerInterface' => [
            'handler' => '\Filebrowser\Services\Logger\Adapters\MonoLogger',
            'config' => [
                'monolog_handlers' => [
                    function () {
                        return new \Monolog\Handler\NullHandler();
                    },
                ],
            ],
        ],
        'Filebrowser\Services\Session\SessionStorageInterface' => [
            'handler' => '\Filebrowser\Services\Session\Adapters\SessionStorage',
            'config' => [
                'handler' => function () {
                    return new \Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage();
                },
            ],
        ],
        'Filebrowser\Services\Tmpfs\TmpfsInterface' => [
            'handler' => '\Filebrowser\Services\Tmpfs\Adapters\Tmpfs',
            'config' => [
                'path' => TEST_TMP_PATH,
                'gc_probability_perc' => 10,
                'gc_older_than' => 60 * 60 * 24 * 2, // 2 days
            ],
        ],
        'Filebrowser\Services\View\ViewInterface' => [
            'handler' => '\Filebrowser\Services\View\Adapters\Vuejs',
            'config' => [
                'add_to_head' => '',
                'add_to_body' => '',
            ],
        ],
        'Filebrowser\Services\Storage\Filesystem' => [
            'handler' => '\Filebrowser\Services\Storage\Filesystem',
            'config' => [
                'separator' => '/',
                'adapter' => function () {
                    return new \League\Flysystem\Adapter\Local(
                        TEST_REPOSITORY
                    );
                },
            ],
        ],
        'Filebrowser\Services\Auth\AuthInterface' => [
            'handler' => '\Tests\MockUsers',
        ],
        'Filebrowser\Services\Archiver\ArchiverInterface' => [
            'handler' => '\Filebrowser\Services\Archiver\Adapters\ZipArchiver',
            'config' => [],
        ],
        'Filebrowser\Services\Process\SymfonyProcessFactory' => [
            'handler' => '\Filebrowser\Services\Process\SymfonyProcessFactory',
            'config' => [],
        ],
        'Filebrowser\Services\Router\Router' => [
            'handler' => '\Filebrowser\Services\Router\Router',
            'config' => [
                'query_param' => 'r',
                'routes_file' => APP_ROOT_DIR . DIR_SEP . 'tests' . DIR_SEP . 'config' . DIR_SEP . 'testroutes.php',
                'routes_optional_file' => APP_ROOT_DIR . DIR_SEP . 'tests' . DIR_SEP . 'config' . DIR_SEP . 'testroutesoptional.php',
                'fastzip' => false
            ],
        ],
    ],
];
