<?
require("../../php/lib/config.php");

$obj = new Cidade();

if($_GET["id"]) {
    $obj = Cidade::find($_GET["id"]);
}
?>

<? include("../../include/header.php"); ?>

<h2>Gerenciar Cidades</h2>

<a href="admin/cidade/list" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/cidade/controller" method="post">
    <input type="hidden" name="action" value="<?= $obj->id ? "update" : "create" ?>" />
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Nome<br />
    <input type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br /><br />
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>