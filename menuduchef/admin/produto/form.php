<?
include("../../include/header.php");

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("Produto");

$restaurantes = Restaurante::all(array("order" => "nome asc"));
$tipos = TipoProduto::all(array("order" => "nome asc"));
?>

<? include("../../include/painel_area_administrativa.php") ;?>

<script type="text/javascript">
    $(function() {
        <? if($obj->id){ ?>
            autoCompleteProdutosAdicionaisCheckBox(<?= $obj->restaurante_id ?>, <?= $obj->id ?>);          
        <? } ?>
	
	$('#restaurantes').change(function() {
	    autoCompleteProdutosAdicionaisCheckBox($(this).val());
	});
    });
</script>

<h2><a href="admin/">Menu Principal</a> &raquo; Gerenciar Produtos</h2>

<a href="admin/produto/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/produto/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    
    Restaurante<br />
    <? if($obj->restaurante_id){ ?>
	<?= $obj->restaurante->nome ?>
    <? } else { ?>
    <select name="restaurante_id" id="restaurantes">
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
    <br /><br />
    
    Nome do produto<br />
    <input type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br /><br />
    
    <? if($tipos) { ?>
    
    Categorias a que o produto pertence:<br />
    
    <? foreach($tipos as $tipo) { ?>
    
    <input type="checkbox" name="tipos[]" value="<?= $tipo->id ?>" id="tipoproduto_id_<?= $tipo->id ?>" <? if($obj->temTipo($tipo->id)) { ?>checked="true"<? } ?>  />
    <label for="tipo_<?= $tipo->id ?>"><?= $tipo->nome ?></label><br />
    
    <? } ?>
    <br />
    <? } ?>
    
    Adicionais disponíveis para o produto:<br />
    <div id="adicionais">Escolha um restaurante primeiro</div>
    <br />
    
    Pre&ccedil;o<br />
    <input type="text" name="preco" value="<?= $obj->preco ?>" maxlength="100" /><br /><br />
    
    Tamanho<br />
    <input type="text" name="tamanho" value="<?= $obj->tamanho ?>" maxlength="100" /><br /><br />
    
    Ativo<br />
    <input type="radio" name="ativo" value="1" <? if (!$obj->id || $obj->ativo === 1) { ?>checked="true"<? } ?> />Sim
    <input type="radio" name="ativo" value="0" <? if ($obj->id && $obj->ativo === 0) { ?>checked="true"<? } ?> />Não
    <br /><br />
    
    Dispon&iacute;vel<br />
    <input type="radio" name="disponivel" value="1" <? if (!$obj->id || $obj->disponivel === 1) { ?>checked="true"<? } ?> />Sim
    <input type="radio" name="disponivel" value="0" <? if ($obj->id && $obj->disponivel === 0) { ?>checked="true"<? } ?> />Não
    <br /><br />
    
    Est&aacute; em Promo&ccedil;&atilde;o<br />
    <input type="radio" name="esta_em_promocao" value="1" <? if ($obj->id && $obj->esta_em_promocao === 1) { ?>checked="true"<? } ?> />Sim
    <input type="radio" name="esta_em_promocao" value="0" <? if (!$obj->id || $obj->esta_em_promocao === 0) { ?>checked="true"<? } ?> />Não
    <br /><br />
    
    Pre&ccedil;o Promocional<br />
    <input type="text" name="preco_promocional" value="<?= $obj->preco_promocional ?>" maxlength="100" /><br /><br />
    
    Descri&ccedil;&atilde;o<br />
    <input type="text" name="descricao" value="<?= $obj->descricao ?>" maxlength="100" /><br /><br />
    
    Quantidade de Produto Adicional<br />
    <input type="text" name="qtd_produto_adicional" value="<?= $obj->qtd_produto_adicional ?>" maxlength="100" /><br /><br />
    
    C&oacute;digo<br />
    <input type="text" name="codigo" value="<?= $obj->codigo ?>" maxlength="100" /><br /><br />
    
    Texto Promo&ccedil;&atilde;o<br />
    <input type="text" name="texto_promocao" value="<?= $obj->texto_promocao ?>" maxlength="100" /><br /><br />
    
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>