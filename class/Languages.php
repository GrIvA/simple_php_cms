<?php
// *** CLASS ***
class Languages {

    private static $instance;

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public static function SetLocalLanguage($lang) {
        self::getInstance();
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
