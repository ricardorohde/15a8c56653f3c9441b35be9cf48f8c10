<?
include("../../include/header.php");

$obj = new Administrador();

if ($_GET["id"]) {
    $obj = Administrador::find($_GET["id"]);
}
?>

<script type="text/javascript">

</script>

<h2>Gerenciar Administradores</h2>

<a href="admin/administrador/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/administrador/controller" method="post">
    <input type="hidden" name="action" value="<?= $obj->id ? "update" : "create" ?>" />
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Nome<br />
    <input type="text" name="nome" autocomplete="off" value="<?= $obj->nome ?>" maxlength="100" /><br />
    Login<br />
    <input type="text" name="login" autocomplete="off" value="<?= $obj->login ?>" maxlength="100" /><br />
    Senha<br />
    <input type="password" name="senha" autocomplete="off" maxlength="100" /><br /><br />
    Repita a senha<br />
    <input type="password" name="senha_rep" autocomplete="off" maxlength="100" /><br /><br />
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>