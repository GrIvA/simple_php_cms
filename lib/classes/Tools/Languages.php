<?php
// *** CLASS ***
namespace Tools;

class Languages
{
    const LANGTABLE = 'languages';

    private static $instance;
    private static $default_language_id;
    private static $current_language_id;
    private static $text_folder;
    private static $languages     = null;
    private static $languages_abr = null;
    private static $domains = array();

    private static $db;

    public static function getInstance($config = null)
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    public function setLocalLanguage($lang)
    {
    }

    public static function translate($text, $domain = null)
    {
        self::getInstance();
        if (is_null(self::$current_language_id)) {
            throw new Exception("Impossible to translate when language has not been set.");
        }

        if (is_null($domain)) {
            return gettext($text);
        } else {
            return dgettext(self::$domains[$domain], $text);
        }
    }

    public static function getLanguageData($conditions = array())
    {
        $languages = self::$db->select(self::LANGTABLE, '*', $conditions);

        foreach ($languages as $language) {
            self::$languages[$language['id']] = $language;
            self::$languages_abr[$language['abr']] = $language['id'];
        }
                
        return array(
            'total_rows' => count($languages),
            'instances'  => self::$languages
        );
    }

    public function setLanguage($language_id)
    {
        if (is_null(self::$languages)) {
            $this->getLanguageData(array());
        }
        if (!array_key_exists($language_id, self::$languages)) {
            throw new Exception('Unknown language: ' . $language_id);
        }
        $language_to_activate = self::$languages[$language_id];
                
        // Set language environment variables
        putenv('LANG=' . $language_to_activate['folder']);
        putenv('LANGUAGE=' . $language_to_activate['folder']);
        setlocale(LC_ALL, $language_to_activate['folder'] . '.utf8');
        setlocale(LC_COLLATE, $language_to_activate['folder'] . '.utf8');
        setlocale(LC_NUMERIC, 'en_US');

        if (isset(self::$domains) && is_array(self::$domains)) {
            foreach (self::$domains as $domain) {
                bindtextdomain($domain, self::$text_folder);
                bind_textdomain_codeset($domain, 'UTF-8');
            }
        }

        textdomain(self::$domains[0]);
        self::$current_language_id = $language_id;
    }

    public function getLanguageID()
    {
        return self::$current_language_id;
    }

    public function getLanguageIDbyABR($abr)
    {
        if (empty($abr)) {
            $id = self::$default_language_id;
        }
        $id = array_key_exists($abr, self::$languages_abr)
            ? self::$languages_abr[$abr]
            : self::$default_language_id;
        return $id;
    }

    public function getLanguageNamebyABR($abr)
    {
    }

    public function getLanguageNamebyID($id)
    {
    }

    public function getLanguageABRbyName($id)
    {
    }

    public function getAvailableLanguages($pageId)
    {
    }

    // === PRIVATE ===

    private function __construct($config)
    {
        self::$default_language_id = $config['current_language_id'];
        self::$text_folder         = $config['gettext_folder'];
        self::$domains             = $config['gettext_domains'];

        self::$db = $config['database'];

        self::getLanguageData();
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}
