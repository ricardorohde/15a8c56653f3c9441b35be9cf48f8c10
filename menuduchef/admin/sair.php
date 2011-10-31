<?
include_once("../php/lib/config.php");

unset($_SESSION['usuario']);
HttpUtil::redirect("../");
?>