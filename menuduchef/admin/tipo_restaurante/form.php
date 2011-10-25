<?
include("../../include/header.php");

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("TipoRestaurante");
?>

<? include("../../include/painel_area_administrativa.php") ;?>

<h2><a href="admin/">Menu Principal</a> &raquo; Gerenciar Tipos de Restaurante</h2>

<a href="admin/tipo_restaurante/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/tipo_restaurante/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Nome<br />
    <input type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br /><br />
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>