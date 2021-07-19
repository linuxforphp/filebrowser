<?php

return [
    [
        'route' => [
            'GET', '/', '\Filebrowser\Controllers\ViewController@index',
        ],
        'roles' => [
            'guest', 'user', 'admin',
        ],
        'permissions' => [
        ],
    ],
    [
        'route' => [
            'POST', '/login', '\Filebrowser\Controllers\AuthController@login',
        ],
        'roles' => [
            'guest',
        ],
        'permissions' => [
        ],
    ],
    [
        'route' => [
            'POST', '/logout', '\Filebrowser\Controllers\AuthController@logout',
        ],
        'roles' => [
            'guest', 'user', 'admin',
        ],
        'permissions' => [
        ],
    ],
    [
        'route' => [
            'GET', '/getuser', '\Filebrowser\Controllers\AuthController@getUser',
        ],
        'roles' => [
            'guest', 'user', 'admin',
        ],
        'permissions' => [
        ],
    ],
    [
        'route' => [
            'POST', '/changepassword', '\Filebrowser\Controllers\AuthController@changePassword',
        ],
        'roles' => [
            'user', 'admin',
        ],
        'permissions' => [
        ],
    ],
    [
        'route' => [
            'GET', '/getconfig', '\Filebrowser\Controllers\ViewController@getFrontendConfig',
        ],
        'roles' => [
            'guest', 'user', 'admin',
        ],
        'permissions' => [
        ],
    ],
    [
        'route' => [
            'POST', '/changedir', '\Filebrowser\Controllers\FileController@changeDirectory',
        ],
        'roles' => [
            'guest', 'user', 'admin',
        ],
        'permissions' => [
            'read',
        ],
    ],
    [
        'route' => [
            'POST', '/getdir', '\Filebrowser\Controllers\FileController@getDirectory',
        ],
        'roles' => [
            'guest', 'user', 'admin',
        ],
        'permissions' => [
            'read',
        ],
    ],
    [
        'route' => [
            'POST', '/copyitems', '\Filebrowser\Controllers\FileController@copyItems',
        ],
        'roles' => [
            'guest', 'user', 'admin',
        ],
        'permissions' => [
            'read', 'write',
        ],
    ],
    [
        'route' => [
            'POST', '/moveitems', '\Filebrowser\Controllers\FileController@moveItems',
        ],
        'roles' => [
            'guest', 'user', 'admin',
        ],
        'permissions' => [
            'read', 'write',
        ],
    ],
    [
        'route' => [
            'POST', '/renameitem', '\Filebrowser\Controllers\FileController@renameItem',
        ],
        'roles' => [
            'guest', 'user', 'admin',
        ],
        'permissions' => [
            'read', 'write',
        ],
    ],
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
            'POST', '/deleteitems', '\Filebrowser\Controllers\FileController@deleteItems',
        ],
        'roles' => [
            'guest', 'user', 'admin',
        ],
        'permissions' => [
            'read', 'write',
        ],
    ],
    [
        'route' => [
            'POST', '/createnew', '\Filebrowser\Controllers\FileController@createNew',
        ],
        'roles' => [
            'guest', 'user', 'admin',
        ],
        'permissions' => [
            'read', 'write',
        ],
    ],
    [
        'route' => [
            'GET', '/upload', '\Filebrowser\Controllers\UploadController@chunkCheck',
        ],
        'roles' => [
            'guest', 'user', 'admin',
        ],
        'permissions' => [
            'upload',
        ],
    ],
    [
        'route' => [
            'POST', '/upload', '\Filebrowser\Controllers\UploadController@upload',
        ],
        'roles' => [
            'guest', 'user', 'admin',
        ],
        'permissions' => [
            'upload',
        ],
    ],
    [
        'route' => [
            'GET', '/download', '\Filebrowser\Controllers\DownloadController@download',
        ],
        'roles' => [
            'guest', 'user', 'admin',
        ],
        'permissions' => [
            'download',
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
    [
        'route' => [
            'GET', '/batchdownload', '\Filebrowser\Controllers\DownloadController@batchDownloadStart',
        ],
        'roles' => [
            'guest', 'user', 'admin',
        ],
        'permissions' => [
            'read', 'download', 'batchdownload',
        ],
    ],
    // admins
    [
        'route' => [
            'GET', '/listusers', '\Filebrowser\Controllers\AdminController@listUsers',
        ],
        'roles' => [
            'admin',
        ],
        'permissions' => [
        ],
    ],
    [
        'route' => [
            'POST', '/storeuser', '\Filebrowser\Controllers\AdminController@storeUser',
        ],
        'roles' => [
            'admin',
        ],
        'permissions' => [
        ],
    ],
    [
        'route' => [
            'POST', '/updateuser/{username}', '\Filebrowser\Controllers\AdminController@updateUser',
        ],
        'roles' => [
            'admin',
        ],
        'permissions' => [
        ],
    ],
    [
        'route' => [
            'POST', '/deleteuser/{username}', '\Filebrowser\Controllers\AdminController@deleteUser',
        ],
        'roles' => [
            'admin',
        ],
        'permissions' => [
        ],
    ],
    [
        'route' => [
            'POST', '/savecontent', '\Filebrowser\Controllers\FileController@saveContent',
        ],
        'roles' => [
            'guest', 'user', 'admin',
        ],
        'permissions' => [
            'read', 'write',
        ],
    ],
];
