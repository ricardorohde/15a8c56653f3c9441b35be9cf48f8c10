<?
include_once("../lib/config.php");

$cep = explode("-",$_GET["cep"]);
$cep = implode("",$cep);
$cep = EnderecoCep::find_by_cep($cep);

echo "<label>Estado</label><input type='text' style='background:#EEE' readonly='true' class='campo' value='".$cep->bairro->cidade->uf->nome."'>";

?>