<?

class StringUtil {

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

}