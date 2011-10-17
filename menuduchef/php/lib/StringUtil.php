<?

class StringUtil {

    static function arrayActiveRecordToJson($collection) {
	$arrayTemp = array();
	foreach($collection as $element) {
	    $arrayTemp[] = $element->to_json();
	}
	
	return "[" . implode(",", $arrayTemp) . "]";
    }
    
    static function doubleToCurrency($value) {
	return $value ? ("R$ " . number_format($value, 2, ',', '.')) : "";
    }

}

?>