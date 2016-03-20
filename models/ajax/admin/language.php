<?php
use CommandHandler\Handler;
use CommandHandler\Middleware;

$request = $_REQUEST;

$handler = new Handler();
$mdw = new Middleware();
$mdw->reverse = function () use (&$request) {
    $request = array_map(function ($elem) {return strrev($elem);}, $request);
    $request['operation'] = strrev($request['operation']);
    return 1;
};

$handler->group('get/', function () use ($mdw) {
    $this->middleware(
        [$mdw->reverse],
        function() {
            $this->add('files', function ($request) {
                return $request;
            });
        },
        []
    );
}, array('request' => $request));

echo json_encode($handler->run($request['operation'], $request));
