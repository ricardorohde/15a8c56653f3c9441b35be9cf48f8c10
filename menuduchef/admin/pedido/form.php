<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("Pedido");

$restaurantes = Restaurante::all(array("order" => "nome asc"));
$consumidores = Consumidor::all(array("order" => "nome asc"));
$preco_total = 0;
//$produtos = Produto::all(array("order" => "nome asc", "conditions" => array("restaurante_id = ?", $obj->restaurante->id)));
?>

<script type="text/javascript">
    $(function() {
	autoCompleteEnderecos(<?= $obj->consumidor_id ?: 0 ?>, <?= $obj->restaurante_id ?: 0 ?>, <?= $obj->endereco_id ?: 0 ?>);
	    
	$('#consumidores').change(function() {
	    autoCompleteEnderecos($(this).val(), $('#restaurantes').val());
	});
        
        $('#restaurantes').change(function() {
	    autoCompleteEnderecos($('#consumidores').val(), $(this).val());
	});
    });
</script>
<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Pedidos</h2>

<a href="admin/pedido/" title="Cancelar">Cancelar</a>

<form action="admin/pedido/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    
    <label class="normal">Consumidor:</label>
    <? if($obj->consumidor_id) { ?>
    <label class="adjacent"><?= $obj->consumidor->nome ?></label>
    <? } else { ?>
    <select class="formfield w40" id="consumidores" name="consumidor_id">
        <option value="">-- Selecione --</option>
	<?
	if ($consumidores) {
	    foreach ($consumidores as $consumidor) {
		?>
		<option value="<?= $consumidor->id ?>" <? if ($consumidor->id == $obj->consumidor_id) { ?>selected="true"<? } ?>><?= $consumidor->nome ?></option>
	    <? }
	} ?>
    </select>
    <? } ?>
    
    <label class="normal">Restaurante:</label>
    <? if($obj->restaurante_id) { ?>
    <label class="adjacent"><?= $obj->restaurante->nome ?></label>
    <? } else { ?>
    <select class="formfield w40" id="restaurantes" name="restaurante_id">
        <option value="">-- Selecione --</option>
	<?
	if ($restaurantes) {
	    foreach ($restaurantes as $restaurante) {
		?>
		<option value="<?= $restaurante->id ?>" <? if ($restaurante->id == $obj->restaurante_id) { ?>selected="true"<? } ?>><?= $restaurante->nome ?></option>
	    <? }
	} ?>
    </select>
    <? } ?>
    
    <label class="normal">Endere&ccedil;o da entrega:</label>
    <select class="formfield w40" id="enderecos" name="endereco_id"></select>
    
    <? if($obj->id) { ?>
    <label class="normal">Itens inclusos:</label>
    <div id="proInput">
    <?
        $proc = 1;
	if($obj->pedido_tem_produtos) {
        foreach($obj->pedido_tem_produtos as $pro){
            $count_ad = 0;
            $valor_adicional = 0;
            $adicionais = "";
            if($pro->pedido_tem_produtos_adicionais){
                foreach($pro->pedido_tem_produtos_adicionais as $adi){
                    if($count_ad>0){
                        $adicionais .= ", ";
                    }
                    $adicionais .= " ".$adi->produto_adicional->nome;
                    $valor_adicional += $adi->preco;
                    $count_ad++;
                }
            }
            $preco_total += (($pro->preco_unitario + $valor_adicional) * $pro->qtd);
             ?>
            <div>
		<label class="adjacent">
		    <?= $pro->qtd ?>x <?= $pro->produto->nome ?>
		    <? if($pro->tamanho) { echo " (".$pro->tamanho.") ";} ?>
		    <? if($adicionais){ echo " ---Adicionais: ".$adicionais." ";} ?>
		    <? if($pro->obs){ echo " ---[OBS:".$pro->obs."] ";} ?>
		    <? echo " ---Valor Unit&aacute;rio: ".StringUtil::doubleToCurrency($pro->preco_unitario);
		    if($adicionais){ echo " + (".$valor_adicional.")"; }
		    ?>
		</label>
            </div>
        <? $proc++; } }
    ?>
    </div>
    <a class="left clear-both top10" href="admin/pedido_tem_produto/?ped=<?= $obj->id ?>">Acrescentar/Modificar/Excluir Itens</a>
    <? } ?>
    
    <label class="normal">Pagamento Efetuado:</label>
    <input class="adjacent" id="pagamento_efetuado_sim" type="radio" name="pagamento_efetuado" value="1" <? if ($obj->id && $obj->pagamento_efetuado === 1) { ?>checked="true"<? } ?> />
    <label for="pagamento_efetuado_sim" class="adjacent">Sim</label>
    <input class="adjacent" id="pagamento_efetuado_nao" type="radio" name="pagamento_efetuado" value="0" <? if (!$obj->id || $obj->pagamento_efetuado === 0) { ?>checked="true"<? } ?> />
    <label for="pagamento_efetuado_nao" class="adjacent">Não</label>
    
    <label class="normal">Forma de Pagamento:</label>
    <input class="formfield w15" type="text" name="forma_pagamento" value="<?= $obj->forma_pagamento ?>" maxlength="100" />
    <? if($_GET['id']){ ?>
    <label class="normal">Pre&ccedil;o:</label>
    <label class="adjacent"><?= StringUtil::doubleToCurrency($obj->getTotal()) ?></label>
    <? } ?>
    
    <label class="normal">Troco:</label>
    <input class="formfield w15" type="text" name="troco" value="<?= $obj->troco ?>" maxlength="100" />
    
    <label class="normal">Cupom:</label>
    <input class="formfield w15" type="text" name="cupom" value="<?= $obj->cupom ?>" maxlength="100" />
    
    <label class="normal">Situa&ccedil;&atilde;o:</label>
    <input class="formfield w15" type="text" name="situacao" value="<?= $obj->situacao ?>" maxlength="100" />
    
    <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar pedido e adicionar produtos" ?>" />
</form>

<? include("../../include/footer_admin.php"); ?>
