<?
include_once("../lib/config.php");

$data = HttpUtil::getParameterArray();

if($data) {
    print_r($data);
}
?>