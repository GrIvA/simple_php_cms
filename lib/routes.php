<?php
$app->get('/main', function () use ($app) {
    $c = getUserCollection($app);
    $storage = $c['session'];
    $current_page = $storage->get('current_page');

    try {
        useTemplate($current_page['file_name'], 'main_layout');
    } catch (Exception $e) {
        dbg($e->getMessage());
    }
});

$app->get('/admin', function () use ($app) {
    $c = getUserCollection($app);
    $storage = $c['session'];
    $current_page = $storage->get('current_page');

    try {
        useTemplate($current_page['file_name'], 'admin_layout');
    } catch (Exception $e) {
        dbg($e->getMessage());
    }
});
