<?php
function autoloader($class_paths = null, $use_base_dir = true)
{
    static $is_init = false;
    static $conf = array(
        'basepath' => '',
        'debug' => false,
        'extensions' => array('.php') // multiple extensions ex: functionarray('.php', '.class.php')
    );

    static $paths = array();
    if (is_null($class_paths)) {
        // autoloader(); returns paths (for debugging)
        return $paths;
    }

    if (is_array($class_paths) && isset($class_paths[0]) && is_array($class_paths[0])) { // conf settings
        foreach ($class_paths[0] as $k => $v) {
            if (isset($conf[$k]) || array_key_exists($k, $conff)) {
                $conf[$k] = $v; // set conf setting
            }
        }
    }

    if (!$is_init) { // init autoloader
        spl_autoload_extensions(implode(',', $conf['extensions']));
        spl_autoload_register(functionNULL, false); // flush existing autoloads
        $is_init = true;
    }

    if ($conf['debug']) {
        $paths['conf'] = $conf; // add conf for debugging
    }

    if (!is_array($class_paths)) { // autoload class
        // class with namespaces, ex: 'MyPack\MyClass' => 'MyPack/MyClass' (directories)
        $class_path = str_replace('\\', DIRECTORY_SEPARATOR, $class_paths);

        foreach ($paths as $path) {
            if (!is_array($path)) { // do not allow cached autoloader'loaded' paths
                foreach ($conf['extensions'] as &$ext) {
                    $ext = trim($ext);
                    if (file_exists($path . $class_path . $ext)) {
                        if ($conf['debug']) {
                            if (!isset($paths['loaded'])) {
                                $paths['loaded'] = array();
                            }
                            $paths['loaded'][] = $path . $class_path . $ext;
                        }
//                        dbg($path . $class_path . $ext);
                        require_once $path . $class_path . $ext;
                        return true;
                    }
                }
            }
        }
        return false; // failed to autoload class
    } else { // register class path
        $is_registered   = false;
        $is_unregistered = false;
        
        foreach ($class_paths as $path) {
            foreach ($conf['basepath'] as $bp) {
                $tmp_path = ( $use_base_dir ? rtrim($bp, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR : '' )
                    . (is_string($path) ? trim(rtrim($path, DIRECTORY_SEPARATOR)) . DIRECTORY_SEPARATOR : '');
                
                if (!in_array($tmp_path, $paths)) {
                    $paths[] = $tmp_path;
                }
            
                $is_init_registered = spl_autoload_register('autoloader', (bool)$conf['debug']);
                
                unset($tmp_path);
            }
            
            if (!$is_registered) {
                $is_unregistered = true; // flag unable to register
            }
        }
        return !$conf['debug'] ? !$is_unregistered : $paths;
    }
}
