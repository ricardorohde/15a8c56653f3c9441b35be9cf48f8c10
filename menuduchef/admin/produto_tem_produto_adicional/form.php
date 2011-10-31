<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("ProdutoTemProdutoAdicional");

$produtos = Produto::all(array("order" => "nome asc"));
$produtos_adicionais = ProdutoAdicional::all(array("order" => "nome asc"));
?>

<h2><a href="admin/">Menu Principal</a> &raquo; Gerenciar Produtos Adicionais pertencentes a Produtos</h2>

<a href="admin/produto_tem_produto_adicional/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/produto_tem_produto_adicional/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Produto<br />
    <select name="produto_id">-- Selecione --</option>
	<?
	if ($produtos) {
	    foreach ($produtos as $produto) {
		?>
		<option value="<?= $produto->id ?>" <? if ($produto->id == $obj->produto_id) { ?>selected="true"<? } ?>><?= $produto->nome ?></option>
	    <? }
	} ?>
    </select>
    <br /><br />
    Produto Adicional<br />
    <select name="produtoadicional_id">-- Selecione --</option>
	<?
	if ($produtos_adicionais) {
	    foreach ($produtos_adicionais as $produto_adicional) {
		?>
		<option value="<?= $produto_adicional->id ?>" <? if ($produto_adicional->id == $obj->produtoadicional_id) { ?>selected="true"<? } ?>><?= $produto_adicional->nome ?></option>
	    <? }
	} ?>
    </select>
    <br /><br />
        
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>