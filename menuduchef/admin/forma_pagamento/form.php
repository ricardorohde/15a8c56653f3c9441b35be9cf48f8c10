<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("FormaPagamento");
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Formas de Pagamento</h2>

<a href="admin/forma_pagamento/" title="Cancelar">Cancelar</a>

<form action="admin/forma_pagamento/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    
    <label class="normal">Nome:</label>
    <input class="formfield w50" type="text" name="nome" value="<?= $obj->nome ?>" maxlength="80" />
    
    <label class="normal">URL:</label>
    <input class="formfield w50" type="text" name="url" value="<?= $obj->url ?>" maxlength="200" />
    
    <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer_admin.php"); ?>