<?php

require_once __DIR__.'/vendor/autoload.php';

return
    [
        'paths' => [
            'migrations' => '%%PHINX_CONFIG_DIR%%/application/migration/migrations',
            'seeds' => '%%PHINX_CONFIG_DIR%%/application/migration/seeds'
        ],
        'environments' => [
            'default_migration_table' => 'phinxlog',
            'default_environment' => 'development',
            'production' => [
                'adapter' => 'mysql',
                'host' => 'localhost',
                'name' => 'production_db',
                'user' => 'root',
                'pass' => '',
                'port' => '3306',
                'charset' => 'utf8',
            ],
            'development' => [
                'adapter' => 'pgsql',
                'host' => 'localhost',
                'name' => 'perpustakaan',
                'user' => 'postgres',
                'pass' => 'postgroow',
                'port' => '65432',
                'charset' => 'utf8',
            ],
            'testing' => [
                'adapter' => 'mysql',
                'host' => 'localhost',
                'name' => 'testing_db',
                'user' => 'root',
                'pass' => '',
                'port' => '3306',
                'charset' => 'utf8',
            ]
        ],
        'version_order' => 'creation'
    ];
