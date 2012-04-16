<?php
ob_start();
session_start();
include("../../include/header2.php");

$gerente = unserialize($_SESSION['usuario_obj']);


if($_POST){
    $data['situacao'] = Pedido::$CANCELADO;
    $data['texto_cancelamento'] = $_POST["textarea"];
    $obj = Pedido::find(array("conditions"=>array("restaurante_id = ? AND id = ?",$gerente->restaurante_id,$_POST['copia2'])));
    if($obj->situacao!=Pedido::$CANCELADO){
        $obj->update_attributes($data);
    }
}

header("location: ../../adar");
?>
