<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("ProdutoTemProdutoAdicional");

$produtos = Produto::all(array("order" => "nome asc"));
$produtos_adicionais = ProdutoAdicional::all(array("order" => "nome asc"));
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Produtos Adicionais pertencentes a Produtos</h2>

<a href="admin/produto_tem_produto_adicional/" title="Cancelar">Cancelar</a>

<form action="admin/produto_tem_produto_adicional/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    
    <label class="normal">Produto:</label>
    <select class="formfield w40" name="produto_id">
	<option value="">-- Selecione --</option>
	<?
	if ($produtos) {
	    foreach ($produtos as $produto) {
		?>
		<option value="<?= $produto->id ?>" <? if ($produto->id == $obj->produto_id) { ?>selected="true"<? } ?>><?= $produto->nome ?></option>
	    <? }
	} ?>
    </select>

    <label class="normal">Produto Adicional:</label>
    <select class="formfield w40" name="produtoadicional_id">
	<option value="">-- Selecione --</option>
	<?
	if ($produtos_adicionais) {
	    foreach ($produtos_adicionais as $produto_adicional) {
		?>
		<option value="<?= $produto_adicional->id ?>" <? if ($produto_adicional->id == $obj->produtoadicional_id) { ?>selected="true"<? } ?>><?= $produto_adicional->nome ?></option>
	    <? }
	} ?>
    </select>
        
    <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer_admin.php"); ?>