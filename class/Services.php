<?php
// *** CLASS ***
class Services {

    const version = '0.0.1';
    const FatalReport = "<b>{header}</b><br />{text}<br />{error}";

    // *** PUBLIC ***

    public static function format($text, $arguments=array()) {
        if (!is_array($arguments)) $arguments = array($arguments);

        $pattern = '{(%[dfs])}';
        $split = preg_split(
            $pattern,
            $text,
            -1,
            PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE
        );

        $index=0;
        foreach($split as $key=>$item) {
            if(preg_match($pattern, $item)) {
                $argument = $index < count($arguments)
                    ? $arguments[$index++] : false;
                switch($item) {
                    case "%d": 
                        $split[$key] = formatInteger($argument); 
                        break;

                    case "%f": 
                        $split[$key] = formatFloat($argument); 
                        break;

                    case "%s": 
                        $split[$key] = (string)$argument; 
                        break;
                }
            }
        }
        return implode("",$split);
    }

    public static function fatalError($title, $params=array(), $error='', $query='') {
        $title = self::format(Languages::translate($title), $params);

        if ($error != '') {
            $error = optimizeTextStrict($error);
            if (strlen($error) > 500) $error = substr($error,0,500).PredefinedDots;
            $error = str_replace('{text}', htmlspecialchars($error), self::FatalReport);
            $error = str_replace('{header}', Languages::translate('fatal_error'), $error);
        }

        if($query != '') {
            $query = optimizeTextStrict($query);
            if (strlen($query) > 500) {
                $query = substr($query,0,500).PredefinedDots;
            }
            $query = str_replace('{text}', htmlspecialchars($query), iself::FatalReport);
            $query = str_replace('{header}', $language["fatal_query"], $query);
        }

        $report = str_replace('{text}', $title, self::FatalReport);
        $report = str_replace('{header}', languages::translate('fatal_title'), $report);
        $report = str_replace('{error}', $error, $report);
        $report = str_replace('{query}', $query, $report);

        self::outputErase();

        @header("Cache-Control: no-store, no-cache, must-revalidate");
        @header("Pragma: no-cache");
        @header("Content-Type: text/html; charset=$language[charset]");

        echo $report;
        self::halt();
    }
    
    // *** PRIVATE ***
    
    private static function outputErase($nocompress = false) {
        if($nocompress) @define('OutputCompressionSkip', true);
        while(ob_get_level() >= 2) ob_end_clean();
        ob_start();
    }
    private static function halt() {
        global $compiler;
        while(ob_get_level()) ob_end_flush();
        if(is_object($compiler)) $compiler->shutdown();
        exit;
    }
}
?>
