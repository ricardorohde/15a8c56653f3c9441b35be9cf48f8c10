<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("Administrador");
?>

<h2><a href="admin/">Menu Principal</a> &raquo; Gerenciar Administradores</h2>

<a href="admin/administrador/" title="Cancelar">Cancelar</a>

<form action="admin/administrador/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    
    <label class="normal">Nome:</label>
    <input class="formfield w50" type="text" name="nome" autocomplete="off" value="<?= $obj->nome ?>" maxlength="100" />
    
    <? include("../../include/inputs_email_senha.php"); ?>

    <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer_admin.php"); ?>