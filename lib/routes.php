<?php
$app->get('/main', function () use ($app) {
    $c = getUserCollection($app);
    $storage = $c['session'];
    $current_page = $storage->get('current_page');

    useTemplate($current_page['file_name'], 'main_layout');
});
$app->get('/admin', function () use ($app) {
    echo '111111111111111111';
});
