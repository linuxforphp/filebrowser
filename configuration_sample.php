<?php

return [
    'public_path' => APP_PUBLIC_PATH,
    'public_dir' => APP_PUBLIC_DIR,
    'overwrite_on_upload' => false,
    'timezone' => 'UTC', // https://www.php.net/manual/en/timezones.php
    'download_inline' => ['pdf'], // download inline in the browser, array of extensions, use * for all

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

    'services' => [
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
        'Filebrowser\Services\Session\SessionStorageInterface' => [
            'handler' => '\Filebrowser\Services\Session\Adapters\SessionStorage',
            'config' => [
                'handler' => function () {
                    $save_path = null; // use default system path
                    //$save_path = __DIR__.'/private/sessions';
                    $handler = new \Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler($save_path);

                    return new \Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage([
                            "cookie_samesite" => "Lax",
                        ], $handler);
                },
            ],
        ],
        'Filebrowser\Services\Cors\Cors' => [
            'handler' => '\Filebrowser\Services\Cors\Cors',
            'config' => [
                'enabled' => APP_ENV == 'production' ? false : true,
            ],
        ],
        'Filebrowser\Services\Tmpfs\TmpfsInterface' => [
            'handler' => '\Filebrowser\Services\Tmpfs\Adapters\Tmpfs',
            'config' => [
                'path' => __DIR__.'/private/tmp/',
                'gc_probability_perc' => 10,
                'gc_older_than' => 60 * 60 * 24 * 2, // 2 days
            ],
        ],
        'Filebrowser\Services\Security\Security' => [
            'handler' => '\Filebrowser\Services\Security\Security',
            'config' => [
                'csrf_protection' => true,
                'csrf_key' => "123456", // randomize this
                'ip_allowlist' => [],
                'ip_denylist' => [],
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
                'config' => [],
                'adapter' => function () {
                    return new \League\Flysystem\Adapter\Local(
                        __DIR__.'/repository'
                    );
                },
            ],
        ],
        'Filebrowser\Services\Archiver\ArchiverInterface' => [
            'handler' => '\Filebrowser\Services\Archiver\Adapters\ZipArchiver',
            'config' => [],
        ],
        'Filebrowser\Services\Auth\AuthInterface' => [
            'handler' => '\Filebrowser\Services\Auth\Adapters\JsonFile',
            'config' => [
                'file' => __DIR__.'/private/users.json',
            ],
        ],
        'Filebrowser\Services\Router\Router' => [
            'handler' => '\Filebrowser\Services\Router\Router',
            'config' => [
                'query_param' => 'r',
                'routes_file' => __DIR__.'/backend/Controllers/routes.php',
            ],
        ],
    ],
];
