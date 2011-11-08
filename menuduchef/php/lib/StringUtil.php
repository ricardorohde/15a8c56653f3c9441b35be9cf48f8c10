<?

class StringUtil {

    static function arrayActiveRecordToJson($collection, $include=null) {
	$arrayTemp = array();

	if ($collection) {
	    foreach ($collection as $element) {
		if($include) {
		    $arrayTemp[] = $element->to_json(array('include' => $include));
		} else {
		    $arrayTemp[] = $element->to_json();
		}
	    }
	}

	return "[" . implode(",", $arrayTemp) . "]";
    }

    static function doubleToCurrency($value) {
	return $value ? ("R$ " . number_format($value, 2, ',', '.')) : "";
    }

}

?>