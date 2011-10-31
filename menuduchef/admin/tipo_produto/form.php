<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("TipoProduto");
?>

<h2><a href="admin/">Menu Principal</a> &raquo; Gerenciar Tipos de Produto</h2>

<a href="admin/tipo_produto/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/tipo_produto/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Nome<br />
    <input type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br /><br />
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>