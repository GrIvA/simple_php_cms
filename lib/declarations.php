<?php
if ( !defined('DEVOLOP') ) define ('DEVELOP', true);

// *** error mode ***
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting (E_ERROR | E_WARNING | E_PARSE | E_STRICT);
//error_reporting(-1);

// *** debug function ***
function _dbg_($content, $return = false) {
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

// *** start autoloader ***
autoloader(array(array('debug' => DEVELOP, 'basepath' => ROOTDIR . 'class')));

// *** define declaration ***
if ( !defined('VENDORDIR') )  define('VENDORDIR', ROOTDIR . 'vendors' . DS);

// text
if ( !defined('CURRENT_LANGUAGE') ) define('CURRENT_LANGUAGE', 1);
if ( !defined('GETTEXT_FOLDER') ) define('GETTEXT_FOLDER', ROOTDIR . 'locale' . DS);
if ( !defined('GETTEXT_DOMAIN') ) define('GETTEXT_DOMAIN', 'messages');

// *** init variables ***

?>
