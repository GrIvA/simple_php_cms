<?php
$result = [
    'page' => [
        'title' => 'home page',
        'name'  => 'pages/' . $file_name . '.razr',
    ],
    'parameters' => [
        'about' => 'Hi! It is my main page!'
    ],
];

if (DEVELOP) {
    $result['debug'] = [
        'session' => $_SESSION,
    ];

}
return $result;
