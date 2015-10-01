<?php

/**
* LanguageHandler
**/
class LanguageHandler
{
	function __construct()
	{ 
        define('LANG', $this->get_lang_from_Browser(array ('de', 'en', 'la'), 'de', null, false));

		switch (LANG) {
			case 'de':
                $this->parse_ini_file('de_DE.ini');
				break;
			case 'en':
				$this->parse_ini_file('en_US.ini');
				break;
			default:
				$this->parse_ini_file('la_LA.ini');
				break;
		}
	}

    function parse_ini_file($file)
    {
        //Dateipfad setzen
        $file_path = dirname(__FILE__).'/../../lang/'.$file;

        //Falls die Datei nicht existiert => Fehlermeldung zurückgeben
        if (!file_exists($file_path)) die($file_path.' does not exist');
        //Der Variable den Inhalt der .ini Datei zuweisen
        $array = parse_ini_file($file_path);

        reset($array);
        //Einmal durch das Array laufen
        while (list($key, $value) = each($array)) {
            //Alle Bindestriche mit einem Unterstrich ersetzen
            $key = str_replace('-', '_', $key);
            //Falls $value leer ist => Wert von $key in Großbuchstaben zuweisen ansonsten der Wert von $value 
            $value = (!empty($value)) ? $value : strtoupper($key);
            //Eine Konstante mit dem Schlüssel $key und dem Wert $value definieren
            define(strtoupper($key), $value);
        }
    }

	// Browsersprache ermitteln
	function get_lang_from_Browser ($allowed_languages, $default_language, $lang_variable = null, $strict_mode = true) {
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