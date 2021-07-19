<?php

return [
    'public_path' => '',
    'public_dir' => __DIR__.'/../../dist',
    'overwrite_on_upload' => false,
    'timezone' => 'UTC', // https://www.php.net/manual/en/timezones.php
    'download_inline' => ['pdf'],

    'frontend_config' => [
        'app_name' => 'FileBrowser',
        'language' => 'english',
        'logo' => 'https://via.placeholder.com/263x55.png',
        'upload_max_size' => 2 * 1024 * 1024,
        'upload_chunk_size' => 1 * 1024 * 1024,
        'upload_simultaneous' => 3,
        'default_archive_name' => 'archive.zip',
        'editable' => ['.txt', '.css', '.js', '.ts', '.html', '.php', '.json', '.md'],
        'date_format' => 'YY/MM/DD hh:mm:ss',
        'guest_redirection' => '', // useful for external auth adapters
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
        'Filebrowser\Services\Router\Router' => [
            'handler' => '\Filebrowser\Services\Router\Router',
            'config' => [
                'query_param' => 'r',
                'routes_file' => __DIR__.'/../../backend/Controllers/routes.php',
            ],
        ],
    ],
];
