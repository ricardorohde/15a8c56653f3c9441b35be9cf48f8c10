<?
$class = "Consumidor";
$parametersToRemove = array("id_cidade", "senha_rep");

include_once("../lib/config.php");
HttpUtil::validateRepeatedParameter("senha", "senha_rep", "Senha n�o repetida corretamente");

include("include/crud.php");
?>