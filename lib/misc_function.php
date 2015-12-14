<?php
// *** debug function ***
function dbg($content, $return = false)
{
    if (DEVELOP) {
        $backtrace = debug_backtrace();
        $to_return = sprintf(
            "<pre><span><b>%s (%s):</b> </span>%s</pre>",
            $backtrace[0]["file"],
            $backtrace[0]["line"],
            is_array($content) || is_object($content)
            ? print_r($content, true) : (is_bool($content) || is_null($content)
                    ? serialize($content) : $content)
        );
        if ($return) {
            return $to_return;
        } else {
            echo $to_return;
        }
    }
}

// *** routing ***
function getPageList()
{
    global $app;
    $c = getUserCollection($app);
    $db = $c['db'];
    $lang = $c['language'];

    return $db->select(
        'page_aliases',
        ['[><]pages' => ['page_aliases.page_id' => 'id']],
        '*',
        ['language_id' => $lang->getLanguageID()]
    );
}

function getPageInfoFromID($id)
{
    global $app;
    $c = getUserCollection($app);
    $storage = $c['session'];
    $lang = $c['language'];

    //Check correct language
    if ($storage->has('current_page')
        && $storage->get('current_page/language_id') != $lang->getLanguageID()
    ) {
        $storage->delete('page_info_id');
    }

    if (!$storage->has('page_info_id')) {
        $infos = [];
        $page_list = getPageList();
        array_walk(
            $page_list,
            function ($value) use (&$infos) {
                $infos[$value['id']] = $value;
            }
        );
        $storage->set('page_info_id', $infos);
    }
    return $storage->get('page_info_id/' . $id, []);
}

function getPageInfoFromAlias($alias)
{
    global $app;
    $c = getUserCollection($app);
    $storage = $c['session'];
    $lang = $c['language'];

    //Check correct language
    if ($storage->has('current_page')
        && $storage->get('current_page/language_id') != $lang->getLanguageID()
    ) {
        $storage->delete('page_info_alias');
    }

    if (!$storage->has('page_info_alias')) {
        $db = $c['db'];
        $lang = $c['language'];

        $infos = [];
        $page_list = getPageList();
        array_walk(
            $page_list,
            function ($value) use (&$infos) {
                $infos[$value['alias']] = $value;
            }
        );
        $storage->set('page_info_alias', $infos);
    }
    return $storage->get('page_info_alias/' . $alias, []);
}

function getRouteFromID($id)
{
    $info = getPageInfoFromID($id);
    return isset($info['router']) ? $info['router'] : '';
}

// *** templates ***
function useTemplate($file_name, $layout)
{
    if (!empty($file_name)) {
        if (!is_file(ROOTDIR . 'models/pages/' . $file_name . '.php')) {
            return;
        }

        if (!is_file(ROOTDIR . 'templates/pages/' . $file_name . '.razr')) {
            return;
        }

        $razr = new Razr\Engine(
            new Razr\Loader\FilesystemLoader(ROOTDIR . 'templates'),
            ROOTDIR . 'templates/cache'
        );

        echo $razr->render(
            $layout . '.razr',
            include ROOTDIR . 'models/pages/' . $file_name . '.php'
        );
    }
}

// *** misc ***
function getUserCollection($application)
{
    return $application->getContainer()->get('settings')['config'];
}
