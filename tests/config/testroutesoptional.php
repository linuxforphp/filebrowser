<?php

if ($config['fastzip'] === true) {
    return [
        [
            'route' => [
                'POST', '/zipitems', '\Filebrowser\Controllers\FileController@zipItemsProc',
            ],
            'roles' => [
                'guest', 'user', 'admin',
            ],
            'permissions' => [
                'read', 'write', 'zip',
            ],
        ],
        [
            'route' => [
                'POST', '/unzipitem', '\Filebrowser\Controllers\FileController@unzipItemProc',
            ],
            'roles' => [
                'guest', 'user', 'admin',
            ],
            'permissions' => [
                'read', 'write', 'zip',
            ],
        ],
        [
            'route' => [
                'POST', '/batchdownload', '\Filebrowser\Controllers\DownloadController@batchDownloadCreateProc',
            ],
            'roles' => [
                'guest', 'user', 'admin',
            ],
            'permissions' => [
                'read', 'download', 'batchdownload',
            ],
        ],
    ];
} else {
    return [
        [
            'route' => [
                'POST', '/zipitems', '\Filebrowser\Controllers\FileController@zipItems',
            ],
            'roles' => [
                'guest', 'user', 'admin',
            ],
            'permissions' => [
                'read', 'write', 'zip',
            ],
        ],
        [
            'route' => [
                'POST', '/unzipitem', '\Filebrowser\Controllers\FileController@unzipItem',
            ],
            'roles' => [
                'guest', 'user', 'admin',
            ],
            'permissions' => [
                'read', 'write', 'zip',
            ],
        ],
        [
            'route' => [
                'POST', '/batchdownload', '\Filebrowser\Controllers\DownloadController@batchDownloadCreate',
            ],
            'roles' => [
                'guest', 'user', 'admin',
            ],
            'permissions' => [
                'read', 'download', 'batchdownload',
            ],
        ],
    ];
}
