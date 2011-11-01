<?
include('../../include/header_admin.php');

//$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("PedidoTemProduto");

$pedido = Pedido::find($_GET['ped']);
$obj = PedidoTemProduto::find($_GET['id']);
$produtos = Produto::all(array("order" => "nome asc", "conditions" => array("restaurante_id = ?",$pedido->restaurante_id)));
$produtos2 = Produto::all(array("order" => "nome asc", "conditions" => array("restaurante_id = ? AND aceita_segundo_sabor = ?",$pedido->restaurante_id,1)));

$aparece_sabores_extras = 0;
?>

<script type="text/javascript">
    $(function() {
        <? if($obj->id){ ?>
            autoCompleteSegundoSabor(<?= $obj->produto_id ?>);          
        <? } ?>

        $('#produtos').change(function() {
            autoCompleteSegundoSabor($(this).val());
        });
    });
</script>
<h2><a href="admin/">Menu Principal</a> &raquo; <a href="admin/pedido">Gerenciar Pedidos</a> &raquo; Gerenciar Produtos inclusos nos Pedidos</h2>

<a href="admin/pedido_tem_produto/?ped=<?= $_GET['ped'] ?>" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/pedido_tem_produto/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    <input type="hidden" name="ped" value="<?= $_GET['ped'] ?>" />
    <input type="hidden" name="pedido_id" value="<?= $_GET['ped'] ?>" />
    <input type="hidden" name="preco_unitario" value="<?= $obj->preco_unitario ?>" />
    
    Pedido<br /><? if($pedido){
            echo $pedido->id." (".$pedido->restaurante->nome.", ".$pedido->consumidor->nome.")";
        }?>
    <br /><br />
    Produto<br /><? if($obj){
                            $count_ad = 0;
                            $valor_adicional = 0;
                            $adicionais = "";
                            if($obj->pedido_tem_produtos_adicionais){
                                foreach($obj->pedido_tem_produtos_adicionais as $adi){
                                    if($count_ad>0){
                                        $adicionais .= ", ";
                                    }
                                    $adicionais .= " ".$adi->produto_adicional->nome;
                                    $valor_adicional += $adi->preco;
                                    $count_ad++;
                                }
                            }
                             ?>
                            <div><? $aparece_sabores_extras = $obj->produto->aceita_segundo_sabor; ?><? echo $obj->produto->nome; ?> <? if($adicionais){ echo " ---Adicionais: ".$adicionais." (Valor total dos adicionais: R$".$valor_adicional.")";} ?></div>
                            <? if($obj->produto->produto_tem_produtos_adicionais){ ?> <a href="admin/pedido_tem_produto_adicional/?prodnoped=<?= $obj->id ?>&ped=<?= $_GET['ped']?>">Acrescentar/Modificar/Excluir Acompanhamentos e Por&ccedil;&otilde;es Extras</a> <? } ?>
                       <? }else{ ?>
    <select id="produtos" name="produto_id">
        <?
            if($produtos){
                $count = 0;
                foreach($produtos as $produto){ 
                    if($count==0){ $aparece_sabores_extras = $produto->aceita_segundo_sabor; }
                    ?>
                    <option saborextra="<?= $produto->aceita_segundo_sabor ?>" value='<?= $produto->id ?>'><?= $produto->nome ?> <? if($produto->tamanho){ ?>(<?= $produto->tamanho ?>)<? } ?></option>
                <? 
                $count++;
                }
            }
        ?>
    </select>
    <? } ?>
    <br /><br />
    Quantidade<br />
    <input type="text" name="qtd" value="<?= $obj->qtd ?>" maxlength="100" /><br /><br />
    Pre&ccedil;o Unit&aacute;rio<br /><? if($obj->preco_unitario){
            echo "R$ ".$obj->preco_unitario;
        }?>
    <br /><br />
    OBS:<br />
    <input type="text" name="obs" value="<?= $obj->obs ?>" maxlength="100" /><br /><br />

    <div id="sabor_extra" style="display:<?= $aparece_sabores_extras ? "block" : "none" ?>">
        Segundo sabor<br /><? if($obj->produto_id){
                            if($obj->produto_id2){
                                echo $obj->produto2->nome;
                            }else{
                                echo "Sem segundo sabor";
                            }
          }else{ ?>
        <select name="produto_id2"><option value="">-- Selecione --</option>
            <?
            if ($produtos2) {
                foreach ($produtos2 as $produto) {
                    ?>
                    <option value="<?= $produto->id ?>" <? if ($produto->id == $obj->produto_id2) { ?>selected="true"<? } ?>><?= $produto->nome ?></option>
                <? }
            } ?>
        </select>
        <? } 
        if($pedido->restaurante->qtd_max_sabores>=3){?>
        <br /><br />
        Terceiro sabor<br /><? if($obj->produto_id){
                            if($obj->produto_id3){
                                echo $obj->produto3->nome;
                            }else{
                                echo "Sem terceiro sabor";
                            }
          }else{ ?>
        <select name="produto_id3"><option value="">-- Selecione --</option>
            <?
            if ($produtos2) {
                foreach ($produtos2 as $produto) {
                    ?>
                    <option value="<?= $produto->id ?>" <? if ($produto->id == $obj->produto_id3) { ?>selected="true"<? } ?>><?= $produto->nome ?></option>
                <? }
            } ?>
        </select>
        <? } 
        }
        if($pedido->restaurante->qtd_max_sabores>=4){?>
            <br /><br />
            
            Quarto sabor<br /><? if($obj->produto_id){
                                if($obj->produto_id4){
                                    echo $obj->produto4->nome;
                                }else{
                                    echo "Sem quarto sabor";
                                }
              }else{ ?>
            <select name="produto_id4"><option value="">-- Selecione --</option>
                <?
                if ($produtos2) {
                    foreach ($produtos2 as $produto) {
                        ?>
                        <option value="<?= $produto->id ?>" <? if ($produto->id == $obj->produto_id4) { ?>selected="true"<? } ?>><?= $produto->nome ?></option>
                    <? }
                } ?>
            </select>
            <? } 
         }?>
        <br />
    
    </div><br />
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>
