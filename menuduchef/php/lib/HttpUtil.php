<?

require_once("constant.php");

class HttpUtil {

    static function getParameterArray() {
	return $_POST ? $_POST : ($_GET ? $_GET : 0);
    }

    static function getCurrentPage() {
	$fileNameArray = explode("/", $_SERVER['PHP_SELF']);
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

}

?>