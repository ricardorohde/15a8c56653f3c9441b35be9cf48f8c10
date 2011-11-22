<?
include_once("../lib/config.php");

$restaurante_atende_bairro = RestauranteAtendeBairro::find_by_restaurante_id_and_bairro_id($_REQUEST["restaurante_id"], $_REQUEST["bairro_id"]);

header("Content-type: application/json;");

if($restaurante_atende_bairro) {
    echo $restaurante_atende_bairro->to_json();
}
?>