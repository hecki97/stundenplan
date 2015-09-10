<?php

/**
* LanguageHandler
**/
class LanguageHandler
{
	public $array;
	public $lang;

	function __construct()
	{ 
		$this->lang = $this->get_lang_from_Browser(array ('de', 'en', 'la'), 'de', null, false);

		switch ($this->lang) {
			case 'de':
				$this->array = $this->get_array_from_file('de_DE.lang');
				break;
			case 'en':
				$this->array = $this->get_array_from_file('en_US.lang');
				break;
			default:
				$this->array = $this->get_array_from_file('la_LA.lang');
				break;
		}
	}

	function get_array_from_file($file)
	{
		return json_decode(file_get_contents('res/lang/'.$file), true);
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