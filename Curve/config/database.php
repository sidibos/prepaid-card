<?php
return [

    'default' => 'dev',
    'connections' => [
        'dev' => [
            'driver'    => env('DB_CONNECTION','mysql'),
            'host'      => env('DB_HOST','lumen-db'),
            'database'  => env('DB_DATABASE','lumen'),
            'username'  => env('DB_USERNAME','app'),
            'password'  => env('DB_PASSWORD','password'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],
        'content' => [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'content',
            'username'  => 'root',
            'password'  => 'secret',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],
    ],
];