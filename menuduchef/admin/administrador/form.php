<?
include("../../include/header.php");

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("Administrador");
?>

<h2>Gerenciar Administradores</h2>

<a href="admin/administrador/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/administrador/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Nome<br />
    <input type="text" name="nome" autocomplete="off" value="<?= $obj->nome ?>" maxlength="100" /><br /><br />
    
    <? include("../../include/inputs_login_senha.php"); ?>

    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>