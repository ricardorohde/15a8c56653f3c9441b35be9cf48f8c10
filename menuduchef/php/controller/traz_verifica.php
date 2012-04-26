<?
include_once("../lib/config.php");

$cep = explode("-",$_GET["cep"]);
$cep = implode("",$cep);
$cep = EnderecoCep::find_by_cep($cep);

if($cep){
    //nada acontece
}else{    
    echo "<script>alert('CEP n\u00e3o encontrado.')</script>";
}

?>