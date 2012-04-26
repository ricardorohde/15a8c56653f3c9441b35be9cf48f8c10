<?
ob_start();
session_start();
include_once("../lib/config.php");
include("../lib/connect_p.php");

function random_string($l){
    $c = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    for($i=0;$i<$l;$i++) $s .= $c{rand(0,strlen($c)-1)};
    return str_shuffle($s);
}


connect();

$usuario_obj = unserialize($_SESSION['usuario_obj']);
$qtd = filtrar_caracteres_malignos($_POST['qtd']);
$valor = filtrar_caracteres_malignos($_POST['valor']);
$lote = LoteCupom::find($_POST['lotecupom_id']);

$quebra = str_split($lote->nome);
$nomeinv = array_reverse($quebra);

if($nomeinv[3]){
    $letra = $nomeinv[3];
}else{
    $letra = $nomeinv[0];
}
$letra = strtoupper($letra);

$num = str_split($lote->id);
$num = array_reverse($num);

$numero = "";
for($i=0;$i<sizeof($num);$i++){
    $numero .= $num[$i];
}

$sufixo = $numero.$letra; 

for($i=0;$i<($qtd * 2);$i++){
    $corpo = random_string(10);
    $codigo = $corpo.$sufixo;
    
    $vetor[$i] = $codigo;
}

sort($vetor);

$j = 0;
for($i=0;$i<(($qtd*2)-1);$i++){
    if($vetor[$i]==$vetor[$i+1]){
        
    }else{
        if(sizeof($vetor_mesmo)<$qtd){
            $vetor_mesmo[$j] = $vetor[$i];
            $j++;
        }
    }
}

for($i=0;$i<$qtd;$i++){
    $sql="INSERT INTO cupom (codigo,valor,usado,administrador_id,lotecupom_id) VALUES ('".$vetor_mesmo[$i]."','$valor','0','".$usuario_obj->id."','".$lote->id."')";
    mysql_query($sql);
}

mysql_close(); 

HttpUtil::redirect("../../admin/cupom/form_emmassa");

?>