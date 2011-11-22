<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("Cidade");
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Cidades</h2>

<a href="admin/cidade/" title="Cancelar">Cancelar</a>

<form action="admin/cidade/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    
    <label class="normal">Nome:</label>
    <input class="formfield w50" type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br /><br />
    
    <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer_admin.php"); ?>