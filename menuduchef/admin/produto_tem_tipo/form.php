<?
include("../../include/header.php");

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("ProdutoTemTipo");

$produtos = Produto::all(array("order" => "nome asc"));
$tipos = TipoProduto::all(array("order" => "nome asc"));
?>

<h2>Gerenciar Produtos tem Tipos</h2>

<a href="admin/produto_tem_tipo/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/produto_tem_tipo/controller" method="post">
    <input type="hidden" name="action" value="<?= $obj->id ? "update" : "create" ?>" />
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Produto<br />
    <select name="id_produto">-- Selecione --</option>
	<?
	if ($produtos) {
	    foreach ($produtos as $produto) {
		?>
		<option value="<?= $produto->id ?>" <? if ($produto->id == $obj->id_produto) { ?>selected="true"<? } ?>><?= $produto->nome ?></option>
	    <? }
	} ?>
    </select>
    <br /><br />
    Tipo<br />
    <select name="id_tipo">-- Selecione --</option>
	<?
	if ($tipos) {
	    foreach ($tipos as $tipo) {
		?>
		<option value="<?= $tipo->id ?>" <? if ($tipo->id == $obj->id_tipo) { ?>selected="true"<? } ?>><?= $tipo->nome ?></option>
	    <? }
	} ?>
    </select>
    <br /><br />
        
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>