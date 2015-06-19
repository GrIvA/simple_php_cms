<?php
// *** CLASS ***
class Languages {
    const LANGTABLE = 'languages';

    private static $instance;
    private static $_current_language;
    private static $_languages     = null;
    private static $_languages_abr = null;
    private static $_domains = array(
        'test' => 'test',
    );

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public static function SetLocalLanguage($lang) {
        self::getInstance();
    }

    public static function translate($text, $domain = null) {
        self::getInstance();
        if (is_null(self::$_current_language)) {
            throw new Exception("Impossible to translate when language has not been set.");
        }
                
        if (is_null($domain)) {
            return gettext($text);
        } else {
            return dgettext(self::$_domains[$domain], $text);
        }
    }

    public static function getIDFromAbr($language_abr) {
        self::getInstance();
                
        if (is_null(self::$_languages)) {
            self::getLanguageData(array());
        }
                
       if (!array_key_exists($language_abr, self::$_languages_abr)) {
           throw new Exception("Language not found");
       }
                
        return self::$_languages_abr[$language_abr];
    }

    public static function getLanguageData($conditions=array()) {
        self::getInstance();

        $db = Database::getInstance();

        $languages = $db->select(self::LANGTABLE, '*', $conditions);

        foreach ($languages as $language) {
            self::$_languages[$language['id']] = $language;
            self::$_languages_abr[$language['abr']] = $language['id'];
        }
                
        return array(
            'total_rows' => count($languages),
            'instances'  => self::$_languages
        );
    }

    public static function setLanguage($language_id) {
        if (is_null(self::$_languages)) {
            self::getLanguageData(array());
        }
        if (!array_key_exists($language_id, self::$_languages)) {
            throw new Exception('Unknown language: ' . $language_id);
        }
        $language_to_activate = self::$_languages[$language_id];
                
        // Set language environment variables
        putenv('LANG=' . $language_to_activate['language_folder']);
        putenv('LANGUAGE=' . $language_to_activate['language_folder']);
        setlocale(LC_ALL, $language_to_activate['language_folder']);
        setlocale(LC_COLLATE, $language_to_activate['language_folder'] . '.utf8');
        setlocale(LC_NUMERIC, 'en_US');

        if (isset(self::$_domains) && is_array(self::$_domains)) {
            foreach (self::$_domains AS $domain) {
                bindtextdomain($domain, GETTEXT_FOLDER);
                //TODO: what doing if codeset is not UTF-8?
                bind_textdomain_codeset($domain, 'UTF-8');
            }
        }

        textdomain(GETTEXT_DOMAIN);
        self::$_current_language = $language_id;
    }



    // === PRIVATE ===

    private function __construct() {
        //TODO: set vars
       $selectedLanguage = "";
       $charEncoding = "";
       $language_abr = "";
           switch ($lang_selected) {
               case "english":
                   $selectedLanguage = "en_US";
                   $charEncoding = "UTF-8";
                   $language_abr = "en";
                   break;
               case "french":
                   $selectedLanguage = "fr_FR";
                   $charEncoding = "UTF-8";
                   $language_abr = "fr";
                   break;
               case "russian":
                   $selectedLanguage = "ru_RU";
                   $charEncoding = "UTF-8";
                   $language_abr = "ru";
                   break;
               case "italian":
                   $selectedLanguage = "it_IT";
                   $charEncoding = "UTF-8";
                   $language_abr = "it";
                   break;
               case "german":
                   $selectedLanguage = "de_DE";
                   $charEncoding = "UTF-8";
                   $language_abr = "de";
                   break;
               case "spanish":
                   $selectedLanguage = "es_ES";
                   $charEncoding = "UTF-8";
                   $language_abr = "es";
                   break;
               case "portuguese":
                   $selectedLanguage = "pt_PT";
                   $charEncoding = "UTF-8";
                   $language_abr = "pt";
                   break;
               case "ukrainian":
                   $selectedLanguage = "uk_UA";
                   $charEncoding = "UTF-8";
                   $language_abr = "uk";
                   break;
               case "croatian":
                   $selectedLanguage = "hr_HR";
                   $charEncoding = "UTF-8";
                   $language_abr = "hr";
                   break;
               case "polish":
                   $selectedLanguage = "pl_PL";
                   $charEncoding = "UTF-8";
                   $language_abr = "pl";
                   break;
               case "arabic":
                   $selectedLanguage = "ar_EG";
                   $charEncoding = "UTF-8";
                   $language_abr = "ar";
                   break;
               case "urdu": // Used to see variables translation
                   $selectedLanguage = "ur_PK";
                   $charEncoding = "UTF-8";
                   $language_abr = "ur";
                   break;
               default:
                   $selectedLanguage = "en_US";
                   $charEncoding = "UTF-8";
                   $language_abr = "en";
                   break;
           }
           putenv("LANG=$selectedLanguage");
           putenv("LANGUAGE=$selectedLanguage");
           setlocale(LC_ALL, $selectedLanguage);
           setlocale(LC_COLLATE, $selectedLanguage.'.utf8');
           setlocale(LC_TIME, $selectedLanguage);
                       
           setlocale(LC_NUMERIC, 'en_US');

           bindtextdomain(GETTEXT_DOMAIN, GETTEXT_FOLDER);
           textdomain(GETTEXT_DOMAIN);

           if (!defined('CHARSET')) {
               define('CHARSET', $charEncoding);
           }
           if (!defined('LANG')) {
               define('LANG', $language_abr);
           }
           if (!defined('LCALL')) {
               define('LCALL', $selectedLanguage);
           }

           setcookie("language", $language_abr, time() + 86400*365, '/');
           $_SESSION["language"] = $language_abr;

    }

    public static function GetLanguageID() {
    }

    public static function GetLanguageIDbyABR($abr) {
    }

    public static function GetLanguageNamebyABR($abr) {
    }

    public static function GetLanguageNamebyID($id) {
    }

    public static function GetLanguageABRbyName($id) {
    }

    public static function GetAvailableLanguages($pageId) {
    }

    private function __clone() {}
    private function __wakeup() {}
}
?>
