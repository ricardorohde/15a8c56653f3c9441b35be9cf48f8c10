<?

$class = "Pedido";
$redirect = false;
include("include/crud.php");

if (!$obj->pedido_tem_produtos) {
    HttpUtil::redirect("../pedido_tem_produto/?ped={$obj->id}");
} else {
    HttpUtil::redirect("./");
}
?>