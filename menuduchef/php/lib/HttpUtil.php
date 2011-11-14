<?

require_once("constant.php");

class HttpUtil {

    static function getParameterArray() {
	return $_POST ? : ($_GET ? : 0);
    }

    static function getCurrentPage() {
	$fileNameArray = explode("/", $_SERVER["PHP_SELF"]);
	return str_replace(".php", "", $fileNameArray[sizeof($fileNameArray) - 1]);
    }

    static function showErrorMessages($arrayMessages) {
	$_SESSION[DEFAULT_ERROR_SESSION_ATTRIBUTE_NAME] = $arrayMessages;
    }

    static function showInfoMessages($arrayMessages) {
	$_SESSION[DEFAULT_INFO_SESSION_ATTRIBUTE_NAME] = $arrayMessages;
    }

    static function showWarningMessages($arrayMessages) {
	$_SESSION[DEFAULT_WARNING_SESSION_ATTRIBUTE_NAME] = $arrayMessages;
    }

    static function startZlib() {
	if (extension_loaded("zlib")) {
	    ob_start("ob_gzhandler");
	}
    }

    static function finishZlib() {
	if (extension_loaded("zlib")) {
	    ob_end_flush();
	}
    }

    static function isLocalhost() {
	return $_SERVER["HTTP_HOST"] == "127.0.0.1" || !preg_match('/(\.[\d\w]+)+/', $_SERVER["HTTP_HOST"]);
    }

    static function validateRepeatedParameter($parameter, $repeatedParameter, $message) {
	$data = self::getParameterArray();

	if ($data[$parameter] != $data[$repeatedParameter]) {
	    $_SESSION["obj"] = $data;
	    static::showErrorMessages(array($message));
	    static::redirect($_SERVER["HTTP_REFERER"]);
	}
    }

    static function validateRepeatedEmailUsuario($email, $excludeId) {
	if (Usuario::emailExiste($email, $excludeId)) {
	    $data = self::getParameterArray();
	    $_SESSION["obj"] = $data;
	    static::showErrorMessages(array("O e-mail \"{$email}\" já é utilizado por outro usuário"));
	    static::redirect($_SERVER["HTTP_REFERER"]);
	}
    }

    static function getActiveRecordObjectBySessionOrGetId($class) {
	$obj = new $class();

	if ($_SESSION["obj"]) {
	    $obj->set_attributes($_SESSION["obj"]);
	    unset($_SESSION["obj"]);
	} elseif ($_GET["id"]) {
	    $obj = $class::find($_GET["id"]);
	}

	return $obj;
    }

    static function redirect($target) {
	header("Location: $target");
	exit;
    }

    static function addArrayInSessionHash($array, $hash) {
	if ($hash) {
	    if (!$_SESSION[$hash]) {
		$_SESSION[$hash] = array();
	    }

	    $_SESSION[$hash][] = $array;
	}
    }

    static function utf8DecodeArray($array) {
	if ($array) {
	    $arrayDecoded = array();

	    foreach ($array as $key => $value) {
		$arrayDecoded[$key] = utf8_decode($value);
	    }

	    return $arrayDecoded;
	}

	return null;
    }

    static function searchAttributeInSessionMatrix($sessionAttribute, $key, $searchValue, $excludeValue=null) {
	$sessionMatrix = $_SESSION[$sessionAttribute];

	if ($sessionMatrix) {
	    if (is_array($sessionMatrix)) {
		foreach ($sessionMatrix as $sessionArray) {
		    if ($sessionArray[$key] == $searchValue && $sessionArray[$key] != $excludeValue) {
			return $sessionArray;
		    }
		}
	    }
	}
	
	return null;
    }

}

?>