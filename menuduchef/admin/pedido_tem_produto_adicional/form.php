<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("PedidoTemProdutoAdicional");

$itens = PedidoTemProdutoAdicional::all(array("order" => "pedidotemproduto_id asc", "conditions" => array("pedidotemproduto_id = ?",$_GET['prodnoped'])));
$pedido_tem_produto = PedidoTemProduto::find_by_id($_GET['prodnoped']);
$produto_tem_adicionais = ProdutoTemProdutoAdicional::all(array("order" => "id asc", "conditions" => array("produto_id = ?", $pedido_tem_produto->produto_id)));

$limite_acompanhamento_alcancado = 0;
$tem_adicionais = 0;

$qtd_acompanhamentos_existente = 0;
    if ($itens) {
        $tem_adicionias = 1;
	foreach ($itens as $item) {
            $qtd_acompanhamentos_existente += $item->produto_adicional->quantas_unidades_ocupa;  
        }
    }
    
    if(($qtd_acompanhamentos_existente>=$pedido_tem_produto->produto->qtd_produto_adicional)&&($pedido_tem_produto->produto->qtd_produto_adicional>0)){
        $limite_acompanhamento_alcancado = 1;
    }
?>

<h2><a href="admin/">Menu Principal</a> &raquo;  <a href="admin/pedido">Gerenciar Pedidos</a> &raquo; <a href="admin/pedido_tem_produto/?ped=<?= $_GET['ped'] ?>">Gerenciar Produtos inclusos nos Pedidos</a> &raquo; Gerenciar Produtos Adicionais inclusos nos Pedidos</h2>

<a href="admin/pedido_tem_produto_adicional/?prodnoped=<?= $_GET['prodnoped'] ?>&ped=<?= $_GET['ped'] ?>" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/pedido_tem_produto_adicional/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    <input type="hidden" name="ped" value="<?= $_GET['ped'] ?>" />
    <input type="hidden" name="prodnoped" value="<?= $_GET['prodnoped'] ?>" />
    <input type="hidden" name="pedidotemproduto_id" value="<?= $_GET['prodnoped'] ?>" />
    Pedido tem Produto<br /><? if($pedido_tem_produto){ 
         echo $pedido_tem_produto->id." ".$pedido_tem_produto->produto->nome;  
      } ?>

    <br /><br />
    <? if($tem_adicionias){ ?>
        <? if($_GET['id']){ ?>
            <?= $obj->produto_adicional->quantas_unidades_ocupa>0 ? "Acompanhamento" : "Por&ccedil;&atilde;o Extra" ?>
        <? } else{ 
                if($limite_acompanhamento_alcancado){
                    echo "Por&ccedil;&atilde;o Extra";
                }else{
                    echo "Acompanhamento ou Por&ccedil;&atilde;o Extra";
                }
           } ?>
        <br />
        <select name="produtoadicional_id"><option>-- Selecione --</option>
            <?
            if ($produto_tem_adicionais) {
                $aviso_nao_tem_porcao_extra = 0;
                foreach ($produto_tem_adicionais as $pta) {
                    if(!$_GET['id']){ 
                        if($limite_acompanhamento_alcancado==0){ 
                            $aviso_nao_tem_porcao_extra = 1;
                            ?>
                            <option value="<?= $pta->produto_adicional->id ?>" <? if ($pta->produto_adicional->id == $obj->produtoadicional_id) { ?>selected="true"<? } ?>><?= $pta->produto_adicional->nome ?></option>
                   <?  }else{ 
                            if($pta->produto_adicional->quantas_unidades_ocupa==0){ 
                                $aviso_nao_tem_porcao_extra = 1;
                                ?>
                                <option value="<?= $pta->produto_adicional->id ?>" <? if ($pta->produto_adicional->id == $obj->produtoadicional_id) { ?>selected="true"<? } ?>><?= $pta->produto_adicional->nome ?></option>
                         <? }
                       }
                    }else{
                    
                        if(($obj->produto_adicional->quantas_unidades_ocupa>0)&&($pta->produto_adicional->quantas_unidades_ocupa>0)){
                            $aviso_nao_tem_porcao_extra = 1;
                            ?>
                           <option value="<?= $pta->produto_adicional->id ?>" <? if ($pta->produto_adicional->id == $obj->produtoadicional_id) { ?>selected="true"<? } ?>><?= $pta->produto_adicional->nome ?></option> 

                        <? }else if(($obj->produto_adicional->quantas_unidades_ocupa==0)&&($pta->produto_adicional->quantas_unidades_ocupa==0)){
                            $aviso_nao_tem_porcao_extra = 1;
                            ?>
                           <option value="<?= $pta->produto_adicional->id ?>" <? if ($pta->produto_adicional->id == $obj->produtoadicional_id) { ?>selected="true"<? } ?>><?= $pta->produto_adicional->nome ?></option> 
                        <? }
                    } 
                }
            }
            if($aviso_nao_tem_porcao_extra==0){ ?>
                           <option selected>-- N&atilde;o h&aacute; por&ccedil;&otilde;es extras cadastradas para este produto --</option>
        <?  }
?>
        </select>
        <br /><br />

        <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
    <? }else{
        echo "Nenhum acompanhamento e/ou por&ccedil;&atilde;o extra cadastrado para este produto.";
    } ?>
</form>

<? include("../../include/footer.php"); ?>