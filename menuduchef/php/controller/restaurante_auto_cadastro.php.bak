<?
include_once("../lib/config.php");

$redirect = "../../gerente_principal";

$data = HttpUtil::getParameterArray();


$bairros=RestauranteAtendeBairro::all(array("conditions"=>array("restaurante_id = ?",$_SESSION['restaurante_id'])));
if($bairros){
    foreach($bairros as $b){
        $b->delete();
    }
}
foreach($data as $key => $d){
    $quebra = explode("_",$key);

    if($quebra[0]=="bairro"){
        $qual = $quebra[1];
        $data2['bairro_id'] = $qual;
        $data2['restaurante_id'] = $_SESSION['restaurante_id'];
        $data2['preco_entrega'] = $data['preco_entrega_'.$qual];
        $data2['tempo_entrega'] = $data['tempo_entrega_'.$qual];

        $b = new RestauranteAtendeBairro($data2);
        $b->save();
    }
}
HttpUtil::redirect($redirect);
?>