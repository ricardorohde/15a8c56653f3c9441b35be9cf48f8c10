<?
include("../../include/header.php");

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("Pedido");

$restaurantes = Restaurante::all(array("order" => "nome asc"));
$consumidores = Consumidor::all(array("order" => "nome asc"));
$preco_total = 0;
//$produtos = Produto::all(array("order" => "nome asc", "conditions" => array("restaurante_id = ?", $obj->restaurante->id)));
?>

<? include("../../include/painel_area_administrativa.php") ;?>

<h2><a href="admin/">Menu Principal</a> &raquo; Gerenciar Pedidos</h2>

<a href="admin/pedido/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/pedido/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Consumidor<br /><? if($obj->consumidor_id){ 
         echo $obj->consumidor->login;  
      }else{ ?>
    <select name="consumidor_id">-- Selecione --</option>
	<?
	if ($consumidores) {
	    foreach ($consumidores as $consumidor) {
		?>
		<option value="<?= $consumidor->id ?>" <? if ($consumidor->id == $obj->consumidor_id) { ?>selected="true"<? } ?>><?= $consumidor->nome ?></option>
	    <? }
	} ?>
    </select>
    <? } ?>
    <br /><br />
    Restaurante<br /><? if($obj->restaurante_id){ 
         echo $obj->restaurante->nome;  
      }else{ ?>
    <select id="restaurantes" name="restaurante_id">-- Selecione --</option>
	<?
	if ($restaurantes) {
	    foreach ($restaurantes as $restaurante) {
		?>
		<option value="<?= $restaurante->id ?>" <? if ($restaurante->id == $obj->restaurante_id) { ?>selected="true"<? } ?>><?= $restaurante->nome ?></option>
	    <? }
	} ?>
    </select>
    <? } ?>
    <br /><br />
    
    <? if($obj->pedido_tem_produtos) { ?>
    Itens inclusos:<br />
    <div id="proInput">
    <?
        $proc = 1;
        foreach($obj->pedido_tem_produtos as $pro){
            $adicionais = "";
            if($pro->pedido_tem_produtos_adicionais){
                foreach($pro->pedido_tem_produtos_adicionais as $adi){
                    $adicionais .= " ".$adi->produto_adicional->nome;
                }
            }
            $preco_total += ($pro->preco_unitario * $pro->qtd);
             ?>
            <div><? echo $pro->qtd; ?>x <? echo $pro->produto->nome; ?> <? if($pro->tamanho){ echo " (".$pro->tamanho.") ";} ?> <? if($adicionais){ echo " ---Acompanhamento: ".$adicionais." ";} ?> <? if($pro->obs){ echo " ---[OBS:".$pro->obs."] ";} ?> <? echo " ---Valor: R$".($pro->preco_unitario * $pro->qtd)." "; ?> </div>
        <? $proc++; }
    ?>
    </div>
    <a href="admin/pedido_tem_produto/?ped=<?= $obj->id ?>">Acrescentar/Modificar/Excluir Itens</a><br /><br />
    <? } ?>
    
    Pagamento Efetuado<br />
    <input type="radio" name="pagamento_efetuado" value="1" <? if (!$obj->id || $obj->pagamento_efetuado === 1) { ?>checked="true"<? } ?> />Sim
    <input type="radio" name="pagamento_efetuado" value="0" <? if ($obj->id && $obj->pagamento_efetuado === 0) { ?>checked="true"<? } ?> />Não
    <br /><br />
    Forma de Pagamento<br />
    <input type="text" name="forma_pagamento" value="<?= $obj->forma_pagamento ?>" maxlength="100" /><br /><br />
    Pre&ccedil;o<br />
    R$ <?= $preco_total ?><br /><br />
    Troco<br />
    <input type="text" name="troco" value="<?= $obj->troco ?>" maxlength="100" /><br /><br />
    Cupom<br />
    <input type="text" name="cupom" value="<?= $obj->cupom ?>" maxlength="100" /><br /><br />
    Endere&ccedil;o<br />
    <input type="text" name="endereco" value="<?= $obj->endereco ?>" maxlength="100" /><br /><br />
    Situa&ccedil;&atilde;o<br />
    <input type="text" name="situacao" value="<?= $obj->situacao ?>" maxlength="100" /><br /><br />
    
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar pedido e adicionar produtos" ?>" />
</form>

<? include("../../include/footer.php"); ?>
