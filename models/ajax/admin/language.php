<?php
use CommandHandler\Handler;
use CommandHandler\Middleware;

$request = $_REQUEST;

$handler = new Handler();
$mdw = new Middleware();
$mdw->reverse = function () {
    return 1;
};
//dbg($mdw);

/*
$mdw->reverse = function () use (&$request) {
    $request = array_map(
        function ($elem) {
            return strrev($elem);
        },
        $request
    );
    $request['operation'] = strrev($request['operation']);
    return 1;
};
 */

$handler->group('get', function () use ($mdw) {
    dbg(func_get_args());
    dbg($this);
    
    $this->middleware(
        [],
        $this->add('files', function ($request) {
            return $request;
        }),
        []
    );
}, array('request' => $request));

/*
$handler->group('get/', function () {
    $this->add('files', function ($request) {
        return $request;
    });
});
 */

die('-----------');
echo json_encode($handler->run($request['operation'], $request));
