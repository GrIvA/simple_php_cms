<?php
$app->add(function ($request, $response, $next) use ($app) {
    $uri = $request->getUri();
    $elements = explode('/', $uri->getPath());

    if (in_array('ajax', $elements)) {
        $response = $next($request, $response);
        return $response;
    }

    //drop empty elements
    array_walk($elements, function ($value, $key) use (&$elements) {
        if (empty($value)) {
            unset($elements[$key]);
        }
    });
    //reorder items
    $elements = array_values($elements);

    //set language
    $language = isset($elements[0]) && strlen($elements[0]) == 2
        ? array_shift($elements) : '';

    $c = getUserCollection($app);
    $storage = $c['session'];
    $lang    = $c['language'];

    $lang->setLanguage($lang->getLanguageIDbyABR($language));

    $page_id = $c['pages_option']['default_page_id'];


    //get page id
    if (!empty($elements[0])) {
        $info = getPageInfoFromAlias(implode('/', $elements));

        $page_id = isset($info['page_id'])
            ? $info['page_id']
            : $c['pages_option']['error_page_id'];
    }

    $storage->set('current_page', getPageInfoFromID($page_id));

    $response = $next(
        $request->withUri($uri->withPath(getRouteFromID($page_id))), $response
    );
    return $response;
});
