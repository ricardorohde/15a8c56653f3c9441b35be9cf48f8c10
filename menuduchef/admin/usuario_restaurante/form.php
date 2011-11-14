<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("UsuarioRestaurante");

$restaurantes = Restaurante::all(array("order" => "nome asc"));
?>

<h2><a href="admin/">Menu Principal</a> &raquo; Gerenciar Gerentes e Atendentes de Restaurantes</h2>

<a href="admin/usuario_restaurante/" title="Cancelar">Cancelar</a>

<form action="admin/usuario_restaurante/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    
    <label class="normal">Nome:</label>
    <input class="formfield w50" type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" />
    
    <label class="normal">Restaurante:</label>
    <select class="formfield w40" name="restaurante_id">
	<option value="">-- Selecione --</option>
	<?
	if ($restaurantes) {
	    foreach ($restaurantes as $restaurante) {
		?>
		<option value="<?= $restaurante->id ?>" <? if ($restaurante->id == $obj->restaurante_id) { ?>selected="true"<? } ?>><?= $restaurante->nome ?></option>
	    <? }
	} ?>
    </select>
    
    <label class="normal">Perfil:</label>
    <select class="formfield w25" name="perfil">
	<option value="0">-- Selecione --</option>
	<option <? if($obj->tipo == Usuario::$GERENTE) { ?>selected="true"<? } ?> value="<?= Usuario::$GERENTE ?>"><?= Usuario::getNomePerfilById(Usuario::$GERENTE) ?></option>
	<option <? if($obj->tipo == Usuario::$ATENDENTE) { ?>selected="true"<? } ?> value="<?= Usuario::$ATENDENTE ?>"><?= Usuario::getNomePerfilById(Usuario::$ATENDENTE) ?></option>
    </select>

    <? include("../../include/inputs_email_senha.php"); ?>

    <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer_admin.php"); ?>