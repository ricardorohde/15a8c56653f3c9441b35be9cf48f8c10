<?

class StringUtil {
    
    static $conectores = array(' ', '-', '/', ',', ';', '\.', '\(');
    static $termosIrrelevantes = array('de', 'do', 'da', 'dos', 'das', 'em', 'na', 'no', 'nas', 'nos');

    static function arrayActiveRecordToJson($collection, $options=null) {
	$arrayTemp = array();

	if ($collection) {
	    foreach ($collection as $element) {
		if ($options) {
		    $arrayTemp[] = $element->to_json($options);
		} else {
		    $arrayTemp[] = $element->to_json();
		}
	    }
	}

	return '[' . implode(',', $arrayTemp) . ']';
    }

    static function matrixAttributesToJson($matrix, $class, $options=null) {
	$collectionToReturn = array();

	if ($matrix) {
	    foreach ($matrix as $array) {
		$collectionToReturn[] = new $class($array);
	    }
	}

	if ($options) {
	    return static::arrayActiveRecordToJson($collectionToReturn, $options);
	} else {
	    return static::arrayActiveRecordToJson($collectionToReturn);
	}
    }

    static function doubleToCurrency($value) {
	return $value ? ('R$ ' . number_format($value, 2, ',', '.')) : '';
    }

    static function capitalize($string) {
	if (!$string) {
	    return $string;
	}

	return strtoupper(substr($string, 0, 1)) . strtolower(substr($string, 1));
    }

    static function capitalizeExpression($string) {
	$string = strtolower($string);
	$words = split(implode('|', static::$conectores), $string);
	$result = '';
	$currentIndex = 0;

	foreach ($words as $word) {
	    $previousIndexOfWord = $currentIndex - 1;
	    $currentIndex += strlen($word) + 1;
	    $concatString = '';
	    if ($previousIndexOfWord >= 0) {
		$concatString = substr($string, $previousIndexOfWord, 1);
	    }
	    
	    if(in_array($word, static::$termosIrrelevantes)) {
		$result .= $concatString . $word;
	    } else {
		$result .= $concatString . static::capitalize($word);
	    }
	}

	return $result;
    }

    static function formataCep($cep) {
	return preg_replace('/(.+)([0-9]{3})$/', '$1-$2', $cep);
    }

}