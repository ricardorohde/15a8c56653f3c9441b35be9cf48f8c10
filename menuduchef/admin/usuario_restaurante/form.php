<?
include("../../include/header.php");

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("UsuarioRestaurante");

$restaurantes = Restaurante::all(array("order" => "nome asc"));
?>

<h2>Gerenciar Usu&aacute;rios de Restaurantes</h2>

<a href="admin/usuario_restaurante/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/usuario_restaurante/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    
    Nome<br />
    <input type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br /><br />
    
    Restaurante<br />
    <select name="restaurante_id">
	<option value="">-- Selecione --</option>
	<?
	if ($restaurantes) {
	    foreach ($restaurantes as $restaurante) {
		?>
		<option value="<?= $restaurante->id ?>" <? if ($restaurante->id == $obj->restaurante_id) { ?>selected="true"<? } ?>><?= $restaurante->nome ?></option>
	    <? }
	} ?>
    </select>
    <br /><br />
    
    Perfil<br />
    <select name="perfil">
	<option value="">-- Selecione --</option>
	<option <? if($obj->perfil == UsuarioRestaurante::$PERFIL_GERENTE) { ?>selected="true"<? } ?> value="<?= UsuarioRestaurante::$PERFIL_GERENTE ?>"><?= UsuarioRestaurante::getNomePerfilById(UsuarioRestaurante::$PERFIL_GERENTE) ?></option>
	<option <? if($obj->perfil == UsuarioRestaurante::$PERFIL_ATENDENTE) { ?>selected="true"<? } ?> value="<?= UsuarioRestaurante::$PERFIL_ATENDENTE ?>"><?= UsuarioRestaurante::getNomePerfilById(UsuarioRestaurante::$PERFIL_ATENDENTE) ?></option>
    </select>
    <br /><br />

    <? include("../../include/inputs_login_senha.php"); ?>

    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>