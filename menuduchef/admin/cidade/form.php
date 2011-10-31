<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("Cidade");
?>

<h2><a href="admin/">Menu Principal</a> &raquo; Gerenciar Cidades</h2>

<a href="admin/cidade/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/cidade/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Nome<br />
    <input type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br /><br />
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>