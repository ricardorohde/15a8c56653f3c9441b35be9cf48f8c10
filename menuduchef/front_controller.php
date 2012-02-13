<?
require_once('php/lib/HttpUtil.php');

$uri = preg_replace(array('/\/+/', '/\?+/'), array('/', '?'), $_GET['uri']);

if(HttpUtil::isLocalhost()) {
    //$uri = str_replace('menuduchef/', '', $uri);
}
//$uri = str_replace('//', '/', $_SERVER['REQUEST_URI']);

echo 'uri: ' . $uri . '<br />';
echo '_GET[uri]: ' . $_GET['uri'] . '<br />';

$splitQueryString = preg_split('/\?+/', $uri);
$queryString = $splitQueryString[sizeof($splitQueryString) - 1];
if($queryString) {
    $splitParameters = preg_split('/&+/', $queryString);
    $splitParameters = $splitParameters ?: array($queryString);
    
    $parameters = array();
    if($splitParameters) {
	foreach ($splitParameters as $parameter) {
	    $splitValue = preg_split('/=+/', $parameter);
	    if($splitValue[0] && $splitValue[1]) {
		$parameters[$splitValue[0]] = $splitValue[1];
	    }
	}
    }
}

echo 'queryString: ' . $queryString . '<br />';

print_r($_GET); echo '<hr />';
$_GET = array_merge($_GET, $parameters);
print_r($_GET); echo '<hr />';

include "$uri.php";
include('/wamp/www/menuduchef/restaurantes.php');
?>