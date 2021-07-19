<?php

if (! defined('REPOSITORY_ROOT')) {
    define('REPOSITORY_ROOT', APP_ROOT_DIR . DIR_SEP . 'repository');
}

return [
    'auth_file' => APP_ROOT_DIR . DIR_SEP . 'private' . DIR_SEP . 'users.json',
    'routes_file' => APP_ROOT_DIR . DIR_SEP . 'config' . DIR_SEP . 'routes.config.php',
    'routes_optional_file' => APP_ROOT_DIR . DIR_SEP . 'config' . DIR_SEP . 'routes.optional.config.php',
    'public_path' => APP_PUBLIC_PATH,
    'public_dir' => APP_PUBLIC_DIR,
    'tmpfs_path' => APP_ROOT_DIR . DIR_SEP . 'private' . DIR_SEP . 'tmp' . DIR_SEP,
    'log_file' => APP_ROOT_DIR . DIR_SEP . 'private' . DIR_SEP . 'logs' . DIR_SEP . 'app.log',
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

    // Choose one of the following
    'storage' => [
        'driver' => [
            'config' => [
                'separator' => '/',
                'config' => [],
                'adapter' => function () {
                    return new \League\Flysystem\Adapter\Local(
                        REPOSITORY_ROOT
                    );
                },
            ],
            'fastzip' => true // LOCAL ONLY! If true, it will override the \League\Flysystem\Adapter\Local adapter, and use the zip and unzip binaries directly.
        ],
        /*'driver' => [
            'config' => [
                'separator' => '/',
                'config' => [],
                'adapter' => function () {
                    return new \League\Flysystem\Sftp\SftpAdapter([
                        'host' => 'example.com',
                        'port' => 22,
                        'username' => 'demo',
                        'password' => 'password',
                        'timeout' => 10,
                    ]);
                },
            ],
        ],*/
        /*'driver' => [
            'config' => [
                'separator' => '/',
                'config' => [],
                'adapter' => function () {
                    $client = new \Aws\S3\S3Client([
                        'credentials' => [
                            'key' => '123456',
                            'secret' => 'secret123456',
                        ],
                        'region' => 'us-east-1',
                        'version' => 'latest',
                    ]);

                    return new \League\Flysystem\AwsS3v3\AwsS3Adapter($client, 'my-bucket-name');
                },
            ],
        ],*/
    ],
];
