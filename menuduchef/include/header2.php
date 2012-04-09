<?

$libDirectoryArray = array("php/lib", "../php/lib", "../../php/lib");

foreach ($libDirectoryArray as $directory) {
    if (is_dir($directory)) {
	$libDirectory = $directory;
    }
}

include_once("{$libDirectory}/config.php");

if (HttpUtil::isLocalhost()) {
    $baseHref = "http://{$_SERVER['HTTP_HOST']}/menuduchef/";
} else {
    $baseHref = URL_PRODUCTION;
}
?>

<? include('messages.php'); ?>