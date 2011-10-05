<?

class HttpUtil {

	static function getParameterArray() {
		return $_POST ? $_POST : ($_GET ? $_GET : 0);
	}

	static function getCurrentPage() {
		$fileNameArray = explode("/", $_SERVER['PHP_SELF']);
		return str_replace(".php", "", $fileNameArray[sizeof($fileNameArray) - 1]);
	}

	static function getControllerFromCurrentPage() {
		return self::getCurrentPage() . DEFAULT_SUFFIX_CONTROLLER;
	}
}
?>