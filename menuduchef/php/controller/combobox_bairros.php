<?php
include_once("../lib/config.php");

$id = $_GET['cidade'];
$cidade = Cidade::find($id);

if($cidade->bairros) {
    foreach($cidade->bairros as $index => $bairro) {
        echo "<option value='".$bairro->id."'>".$bairro->nome."</option>";
    }
}

?>