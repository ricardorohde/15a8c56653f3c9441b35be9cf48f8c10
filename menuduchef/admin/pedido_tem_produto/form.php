<?
include('../../include/header_admin.php');

//$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("PedidoTemProduto");

$pedido = Pedido::find($_GET['ped']);
$obj = PedidoTemProduto::find($_GET['id']);
$produtos = Produto::all(array("order" => "nome asc", "conditions" => array("restaurante_id = ?", $pedido->restaurante_id)));
$produtos2 = Produto::all(array("order" => "nome asc", "conditions" => array("restaurante_id = ? AND aceita_segundo_sabor = ?", $pedido->restaurante_id, 1)));

$aparece_sabores_extras = 0;
?>

<script type="text/javascript">
    $(function() {
	<? if ($obj->id) { ?>
	    autoCompleteSegundoSabor(<?= $obj->produto_id ?>);          
	<? } ?>

	$('#produtos').change(function() {
	    autoCompleteSegundoSabor($(this).val());
	});
    });
</script>
<h2><a href="admin/">Menu Principal</a> &raquo; <a href="admin/pedido">Gerenciar Pedidos</a> &raquo; Gerenciar Produtos inclusos nos Pedidos</h2>

<a href="admin/pedido_tem_produto/?ped=<?= $_GET['ped'] ?>" title="Cancelar">Cancelar</a>

<form action="admin/pedido_tem_produto/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    <input type="hidden" name="ped" value="<?= $_GET['ped'] ?>" />
    <input type="hidden" name="pedido_id" value="<?= $_GET['ped'] ?>" />
    <input type="hidden" name="preco_unitario" value="<?= $obj->preco_unitario ?>" />

    <label class="normal">Pedido:</label>
    <? if ($pedido) { ?>
        <label class="adjacent"><?= $pedido ?></label>
    <? } ?>

    <label class="normal">Produto:</label>
    <?
    if ($obj) {
	$count_ad = 0;
	$valor_adicional = 0;
	$adicionais = "";
	if ($obj->pedido_tem_produtos_adicionais) {
	    foreach ($obj->pedido_tem_produtos_adicionais as $adi) {
		if ($count_ad > 0) {
		    $adicionais .= ", ";
		}
		$adicionais .= " " . $adi->produto_adicional->nome;
		$valor_adicional += $adi->preco;
		$count_ad++;
	    }
	}
	?>
    
        <div>
	<? $aparece_sabores_extras = $obj->produto->aceita_segundo_sabor; ?>
	<label class="adjacent"><?= $obj->produto->nome ?></label>
	<? if ($adicionais) { ?>
	    <label class="adjacent"><?= " ---Adicionais: " . $adicionais . " (Valor total dos adicionais: " . StringUtil::doubleToCurrency($valor_adicional) . ")" ?></label>
	<? } ?>
	</div>
    
	<? if ($obj->produto->produto_tem_produtos_adicionais) { ?>
	<a class="left clear-both top10" href="admin/pedido_tem_produto_adicional/?prodnoped=<?= $obj->id ?>&ped=<?= $_GET['ped'] ?>">Acrescentar/Modificar/Excluir Acompanhamentos e Por&ccedil;&otilde;es Extras</a>
	<? } ?>
	<? } else { ?>
        <select class="formfield w40" id="produtos" name="produto_id">
	    <?
	    if ($produtos) {
		$count = 0;
		foreach ($produtos as $produto) {
		    if ($count == 0) {
			$aparece_sabores_extras = $produto->aceita_segundo_sabor;
		    }
		    ?>
	    	<option saborextra="<?= $produto->aceita_segundo_sabor ?>" value='<?= $produto->id ?>'><?= $produto->nome ?> <? if ($produto->tamanho) { ?>(<?= $produto->tamanho ?>)<? } ?></option>
		    <?
		    $count++;
		}
	    }
	    ?>
        </select>
<? } ?>
	    
    <label class="normal">Quantidade:</label>
    <input class="formfield w15" type="text" name="qtd" value="<?= $obj->qtd ?>" maxlength="100" />
    
    <? if ($_GET['id']) { ?>
    <label class="normal">Pre&ccedil;o Unit&aacute;rio</label>
    <label class="adjacent"><?= StringUtil::doubleToCurrency($obj->preco_unitario) ?></label>
    <? } ?>
	
    <label class="normal">OBS:</label>
    <textarea class="formfield" name="obs"><?= $obj->obs ?></textarea>

    <div id="sabor_extra" style="display:<?= $aparece_sabores_extras ? "block" : "none" ?>">
	<label class="normal">Segundo sabor:</label>
	<?
	if ($obj->produto_id) {
	    if ($obj->produto_id2) {
	?>
	    <label class="adjacent"><?= $obj->produto2->nome ?></label>
	<? } else { ?>
	    <label class="adjacent">Sem segundo sabor</label>
	<? } } else { ?>
	<select class="formfield w40" name="produto_id2"><option value="">-- Selecione --</option>
		<?
		if ($produtos2) {
		    foreach ($produtos2 as $produto) {
			?>
	    	    <option value="<?= $produto->id ?>" <? if ($produto->id == $obj->produto_id2) { ?>selected="true"<? } ?>><?= $produto->nome ?></option>
		<? }
	    } ?>
    	</select>
	
	<? } ?>
	
	<? if ($pedido->restaurante->qtd_max_sabores >= 3) { ?>
	<label class="normal">Terceiro sabor:</label>
	<?
	if ($obj->produto_id) {
	    if ($obj->produto_id3) {
	?>
	    <label class="adjacent"><?= $obj->produto3->nome ?></label>
	<? } else { ?>
	    <label class="adjacent">Sem terceiro sabor</label>
	<? } } else { ?>
	    <select name="produto_id3"><option value="">-- Selecione --</option>
		<?
		if ($produtos2) {
		    foreach ($produtos2 as $produto) {
		?>
		    <option value="<?= $produto->id ?>" <? if ($produto->id == $obj->produto_id3) { ?>selected="true"<? } ?>><?= $produto->nome ?></option>
		<? }
		} ?>
	    </select>
	<? } } ?>
	
	<? if ($pedido->restaurante->qtd_max_sabores >= 4) { ?>
	<label class="adjacent">Quarto sabor:</label<
	<?
	if ($obj->produto_id) {
	    if ($obj->produto_id4) {
	?>
	    <label class="adjacent"><?= $obj->produto4->nome ?></label>
	<? } else { ?>
	    <label class="adjacent">Sem quarto sabor</label>
	<? } } else { ?>
	    <select name="produto_id4"><option value="">-- Selecione --</option>
		<?
		if ($produtos2) {
		    foreach ($produtos2 as $produto) {
		?>
		    <option value="<?= $produto->id ?>" <? if ($produto->id == $obj->produto_id4) { ?>selected="true"<? } ?>><?= $produto->nome ?></option>
		<? }
	    } ?>
	    </select>
	<? } } ?>
    </div>
    
    <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer_admin.php"); ?>
