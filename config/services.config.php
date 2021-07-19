<?php

return [
    'services' => [
        'Filebrowser\Services\Logger\LoggerInterface' => [
            'handler' => '\Filebrowser\Services\Logger\Adapters\MonoLogger',
            'config' => [
                'monolog_handlers' => [
                    function () use ($baseConfig) {
                        return new \Monolog\Handler\StreamHandler(
                            $baseConfig['log_file'],
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
                'path' => $baseConfig['tmpfs_path'],
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
            'config' => $baseConfig['storage']['driver']['config'],
        ],
        'Filebrowser\Services\Archiver\ArchiverInterface' => [
            'handler' => '\Filebrowser\Services\Archiver\Adapters\ZipArchiver',
            'config' => [],
        ],
        'Filebrowser\Services\Process\SymfonyProcessFactory' => [
            'handler' => '\Filebrowser\Services\Process\SymfonyProcessFactory',
            'config' => [],
        ],
        'Filebrowser\Services\Auth\AuthInterface' => [
            'handler' => '\Filebrowser\Services\Auth\Adapters\JsonFile',
            'config' => [
                'file' => $baseConfig['auth_file'],
            ],
        ],
        'Filebrowser\Services\Router\Router' => [
            'handler' => '\Filebrowser\Services\Router\Router',
            'config' => [
                'query_param' => 'r',
                'routes_file' => $baseConfig['routes_file'],
                'routes_optional_file' => $baseConfig['routes_optional_file'],
                'fastzip' =>  get_class($baseConfig['storage']['driver']['config']['adapter']()) === 'League\Flysystem\Adapter\Local'
                                && isset($baseConfig['storage']['driver']['fastzip'])
                                && $baseConfig['storage']['driver']['fastzip'] === true
                                    ?: false
            ],
        ],
    ],
];