<?php

/**
* LanguageHandler
**/
class LanguageHandler
{
    private function __construct() {}
    private static $initialized = false;

    private static $allowed_languages = array();
    private static $lang_path;

	private static function initialize()
	{
        if (self::$initialized) return;
        require_once(PROJECT_DIR.'/bootstrap.php');

        self::$lang_path = PROJECT_DIR.'/resources/lang';

        $allowed_languages = FileLoader::Scan_dir(self::$lang_path, 'ini', true);
        if (count($allowed_languages) <= 0) die('No valid language files found in "'.self::$lang_path.'"');

        for ($i = 0; $i < count($allowed_languages); $i++) { 
            $tmp_lang = explode('_', $allowed_languages[$i]);
            $lang_array[] = $tmp_lang[0];
        }

        define('LANG', self::get_lang_from_Browser($lang_array, DEFAULT_LANGUAGE, null, false));

        self::$initialized = true;
	}

    public static function ParseLangFile() {
        self::initialize();

        IniParser::Parse(PROJECT_DIR.'/resources/lang/'.LANG.'_'.strtoupper(LANG).'.ini');
    }

	// Browsersprache ermitteln
	private static function get_lang_from_Browser ($allowed_languages, $default_language, $lang_variable = null, $strict_mode = true) {
        // $_SERVER['HTTP_ACCEPT_LANGUAGE'] verwenden, wenn keine Sprachvariable mitgegeben wurde
        if ($lang_variable === null) {
            $lang_variable = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        }

        // wurde irgendwelche Information mitgeschickt?
        if (empty($lang_variable)) {
            // Nein? => Standardsprache zurückgeben
            return $default_language;
        }

        // Den Header auftrennen
        $accepted_languages = preg_split('/,\s*/', $lang_variable);

        // Die Standardwerte einstellen
        $current_lang = $default_language;
        $current_q = 0;
        // Nun alle mitgegebenen Sprachen abarbeiten
        foreach ($accepted_languages as $accepted_language) {
            // Alle Infos über diese Sprache rausholen
            $res = preg_match ('/^([a-z]{1,8}(?:-[a-z]{1,8})*)'.'(?:;\s*q=(0(?:\.[0-9]{1,3})?|1(?:\.0{1,3})?))?$/i', $accepted_language, $matches);
            // war die Syntax gültig?
            if (!$res) {
                // Nein? Dann ignorieren
                continue;
            }
            
            // Sprachcode holen und dann sofort in die Einzelteile trennen
            $lang_code = explode ('-', $matches[1]);

            // Wurde eine Qualität mitgegeben?
            if (isset($matches[2])) {
                // die Qualität benutzen
                $lang_quality = (float)$matches[2];
            }
            else
            {
                // Kompabilitätsmodus: Qualität 1 annehmen
                $lang_quality = 1.0;
            }

            // Bis der Sprachcode leer ist...
            while (count ($lang_code)) {
                // mal sehen, ob der Sprachcode angeboten wird
                if (in_array (strtolower (join ('-', $lang_code)), $allowed_languages)) {
                    // Qualität anschauen
                    if ($lang_quality > $current_q) {
                        // diese Sprache verwenden
                        $current_lang = strtolower (join ('-', $lang_code));
                        $current_q = $lang_quality;
                        // Hier die innere while-Schleife verlassen
                        break;
                    }
            	}
                // Wenn wir im strengen Modus sind, die Sprache nicht versuchen zu minimalisieren
                if ($strict_mode) {
                    // innere While-Schleife aufbrechen
                    break;
                }
                // den rechtesten Teil des Sprachcodes abschneiden
                array_pop ($lang_code);
            }
        }

	    // die gefundene Sprache zurückgeben
	    return $current_lang;
	}
}

?>