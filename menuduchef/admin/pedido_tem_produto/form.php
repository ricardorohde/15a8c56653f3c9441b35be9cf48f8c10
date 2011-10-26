<?
include("../../include/header.php");

//$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("PedidoTemProduto");

$pedido = Pedido::find($_GET['ped']);
$obj = PedidoTemProduto::find($_GET['id']);
$produtos = Produto::all(array("order" => "nome asc", "conditions" => array("restaurante_id = ?",$pedido->restaurante_id)));


?>

<? include("../../include/painel_area_administrativa.php") ;?>


<h2><a href="admin/">Menu Principal</a> &raquo; <a href="admin/pedido">Gerenciar Pedidos</a> &raquo; Gerenciar Produtos inclusos nos Pedidos</h2>

<a href="admin/pedido_tem_produto/?ped=<?= $_GET['ped'] ?>" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/pedido_tem_produto/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    <input type="hidden" name="ped" value="<?= $_GET['ped'] ?>" />
    Pedido<br /><? if($obj->pedido_id){
            echo $obj->pedido_id." (".$obj->pedido->restaurante->nome.", ".$obj->pedido->consumidor->nome.")";
        }else{ ?>
    <select id="pedidos" name="pedido_id">-- Selecione --</option>
	<?        
            if ($pedidos) {
                foreach ($pedidos as $pedido) {
                    ?>
                    <option value="<?= $pedido->id ?>" <? if ($pedido->id == $obj->pedido_id) { ?>selected="true"<? } ?>><?= $pedido->id." (".$pedido->restaurante->nome.", ".$pedido->consumidor->nome.")" ?></option>
                <? }
            }
	?>
    </select>
    <? } ?>
    <br /><br />
    Produto<br /><? if($obj){
                        
                            $adicionais = "";
                            if($obj->pedido_tem_produtos_adicionais){
                                foreach($obj->pedido_tem_produtos_adicionais as $adi){
                                    $adicionais .= " ".$adi->produto_adicional->nome;
                                }
                            }
                             ?>
                            <div><? echo $obj->produto->nome; ?> <? if($adicionais){ echo " ---Acompanhamento: ".$adicionais." ";} ?></div>
                            <? if($obj->produto->produto_tem_produtos_adicionais){ ?> <a href="admin/pedido_tem_produto_adicional/?prodnoped=<?= $obj->id ?>&ped=<?= $_GET['ped']?>">Acrescentar/Modificar/Excluir Adicionais</a> <? } ?>
                       <? }else{ ?>
    <select id="produtos" name="produto_id">
        <?
            if($produtos){
                foreach($produtos as $produto){ ?>
                    <option value='<?= $produto->id ?>'><?= $produto->nome ?> <? if($produto->tamanho){ ?>(<?= $produto->tamanho ?>)<? } ?></option>
                <?}
            }
        ?>
    </select>
    <? } ?>
    <br /><br />
    Quantidade<br />
    <input type="text" name="qtd" value="<?= $obj->qtd ?>" maxlength="100" /><br /><br />
    OBS:<br />
    <input type="text" name="obs" value="<?= $obj->obs ?>" maxlength="100" /><br /><br />

    Produto2<br /><? if($obj->produto_id){
                        if($obj->produto_id2){
                            echo $obj->produto2->nome;
                        }else{
                            echo "Sem segundo sabor";
                        }
      }else{ ?>
    <select name="produto2_id"><option value="">-- Selecione --</option>
	<?
	if ($produtos) {
	    foreach ($produtos as $produto) {
		?>
		<option value="<?= $produto->id ?>" <? if ($produto->id == $obj->produto2_id) { ?>selected="true"<? } ?>><?= $produto->nome ?></option>
	    <? }
	} ?>
    </select>
    <? } ?>
    <br /><br />
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>
