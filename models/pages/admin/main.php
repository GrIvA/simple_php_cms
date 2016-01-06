<?php
$result = [
    'page' => [
        'title'       => 'admin page',
        'name'        => 'pages/' . $file_name . '.razr',
        'header_menu' => 'elements/admin/header_menu.razr',
    ],
    'parameters' => [
        'header' => 'Hi! It is my admin interface!'
    ],
];

if (DEVELOP) {
    $result['debug'] = [
        'session' => $_SESSION,
    ];

}
return $result;
