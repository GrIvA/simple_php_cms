<?php
$result = [
    'page' => [
        'title' => 'Error page',
        'name'  => 'pages/' . $file_name . '.razr',
    ],
    'parameters' => [
        'about' => 'Hi! It is my error page!'
    ],
];

if (DEVELOP) {
    $result['debug'] = [
        'session' => $_SESSION,
    ];

}
return $result;
