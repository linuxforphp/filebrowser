<?php

return [
    [
        'route' => [
            'GET', '/', '\Filebrowser\Controllers\ViewController@index',
        ],
        'roles' => [
            'guest',
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
            'GET', '/noguests', 'ProtectedController@protectedMethod',
        ],
        'roles' => [
            'user', 'admin',
        ],
        'permissions' => [
        ],
    ],
    [
        'route' => [
            'GET', '/adminonly', 'AdminController@adminOnlyMethod',
        ],
        'roles' => [
            'admin',
        ],
        'permissions' => [
        ],
    ],
];
