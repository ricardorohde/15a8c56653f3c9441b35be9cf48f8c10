<?
include_once("../lib/config.php");

$redirect = "../../gerente_principal";

$data = HttpUtil::getParameterArray();

function mascara($x){
    $quebra = explode(".",$x);
    $x = implode("",$quebra);
    $quebra = explode(",",$x);
    $centavos = $quebra[1];
    $real = $quebra[0];
    $quebra = explode(".",$real);
    $real = implode("",$quebra);
    $x = $real.".".$centavos;

    return $x;
}

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
        $data2['preco_entrega'] = mascara($data['preco_entrega_'.$qual]);
        $data2['tempo_entrega'] = $data['tempo_entrega_'.$qual];

        $b = new RestauranteAtendeBairro($data2);
        $b->save();
    }
}
HttpUtil::redirect($redirect);
?>