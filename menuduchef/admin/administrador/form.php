<?
include_once("../../php/lib/config.php");

$obj = new Administrador();

if ($_GET["id"]) {
    $obj = Administrador::find($_GET["id"]);
}
?>

<? include("../../include/header.php"); ?>

<h2>Gerenciar Administradores</h2>

<a href="admin/administrador/list" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/administrador/controller" method="post">
    <input type="hidden" name="action" value="<?= $obj->id ? "update" : "create" ?>" />
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Nome: 
    <input type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br />
    Login: 
    <input type="text" name="login" value="<?= $obj->login ?>" maxlength="100" /><br />
    Senha: 
    <input type="text" name="senha" value="<?= $obj->senha ?>" maxlength="100" /><br /><br />
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>