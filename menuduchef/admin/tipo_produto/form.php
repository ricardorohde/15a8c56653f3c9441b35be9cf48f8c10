<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("TipoProduto");
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Tipos de Produto</h2>

<a href="admin/tipo_produto/" title="Cancelar">Cancelar</a>

<form action="admin/tipo_produto/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    
    <label class="normal">Nome:</label>
    <input class="formfield w50" type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" />
    
    <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer_admin.php"); ?>