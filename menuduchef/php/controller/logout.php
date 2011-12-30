<?
include_once("../lib/config.php");

session_destroy();
HttpUtil::redirect('../../');
?>