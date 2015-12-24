<?php
$result = [
    'page' => [
        'title' => 'admin page',
        'name'  => 'pages/' . $file_name . '.razr',
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
