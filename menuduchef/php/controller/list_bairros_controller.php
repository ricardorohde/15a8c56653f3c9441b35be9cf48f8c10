<?
include_once("../lib/config.php");

$cidade = Cidade::find($_REQUEST["id"]);

$total = sizeof($cidade->bairros);

if($cidade->bairros) {
	echo "[";
	foreach($cidade->bairros as $index => $bairro) {
		echo "\"{$bairro->nome}\"";
		if(($index + 1) < $total) echo ", ";
	}
	echo "]";
}
?>