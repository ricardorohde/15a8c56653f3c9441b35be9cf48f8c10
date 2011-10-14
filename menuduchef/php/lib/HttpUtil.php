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
	return $_SERVER["HTTP_HOST"] == "localhost" || $_SERVER["HTTP_HOST"] == "127.0.0.1";
    }

    static function validateRepeatedParameter($parameter, $repeatedParameter, $message) {
	$data = self::getParameterArray();

	if ($data[$parameter] != $data[$repeatedParameter]) {
	    $_SESSION["obj"] = $data;
	    HttpUtil::showErrorMessages(array($message));
	    header("Location: {$_SERVER["HTTP_REFERER"]}");
	    exit;
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

}

?>