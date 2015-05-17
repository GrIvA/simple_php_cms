<?php
//TODO: files header

// *** error mode ***
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting (E_ERROR | E_WARNING | E_PARSE | E_STRICT);
//error_reporting(-1);

autoloader(array('debug' => DEVELOP, 'basepath' => ROOTDIR . 'class'));
?>
