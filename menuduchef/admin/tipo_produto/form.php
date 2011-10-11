<?
include("../../include/header.php");

$obj = new TipoProduto();

if($_GET["id"]) {
    $obj = TipoProduto::find($_GET["id"]);
}
?>

<h2>Gerenciar Tipos de Produto</h2>

<a href="admin/tipo_produto/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/tipo_produto/controller" method="post">
    <input type="hidden" name="action" value="<?= $obj->id ? "update" : "create" ?>" />
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Nome<br />
    <input type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br /><br />
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>