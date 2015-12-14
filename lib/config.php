<?php
use Pimple\Container as pc;

//$container = new \Slim\Container(
$container = new pc(
    [
        'db_connect' => [
            'database_type' => 'mysql',
            'database_name' => 'PHPC',
            'server'        => 'localhost',
            'username'      => 'simple',
            'password'      => '3s5YeB08ecFlmrOQ',
            'charset'       => 'utf8',
            'port'          => 3306,
            'option'        => [PDO::ATTR_CASE => PDO::CASE_NATURAL]
        ],
        'language_config' => [
            'current_language_id' => 1,
            'gettext_folder'      => ROOTDIR . 'locale' . DS,
            'gettext_domains'     => ['messages'] // first item will be current domain
        ],
        'pages_option' => [
            'default_page_id' => 1,
            'error_page_id'   => 2,
        ]
    ]
);

// *** read service providers ***
$files = scandir(CLASSDIR . DS . 'Helpers');

foreach ($files as $file) {
    if (!is_file(CLASSDIR . DS . 'Helpers' . DS . $file)) {
        continue;
    }

    if (strpos($file, 'ServiceProvider') !== false) {
        $obj_name = 'Helpers\\' . substr($file, 0, -4);
        $container->register(new $obj_name($container));
    }
}
