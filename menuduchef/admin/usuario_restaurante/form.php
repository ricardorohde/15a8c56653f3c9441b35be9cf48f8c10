<?
include("../../include/header.php");

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("UsuarioRestaurante");

$restaurantes = Restaurante::all(array("order" => "nome asc"));
?>

<h2>Gerenciar Usu&aacute;rios de Restaurantes</h2>

<a href="admin/usuario_restaurante/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/usuario_restaurante/controller" method="post">
    <input type="hidden" name="action" value="<?= $obj->id ? "update" : "create" ?>" />
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Nome<br />
    <input type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br /><br />
    Restaurante<br />
    <select name="id_restaurante">
	<option value="">-- Selecione --</option>
	<?
	if ($restaurantes) {
	    foreach ($restaurantes as $restaurante) {
		?>
		<option value="<?= $restaurante->id ?>" <? if ($restaurante->id == $obj->id_restaurante) { ?>selected="true"<? } ?>><?= $restaurante->nome ?></option>
	    <? }
	} ?>
    </select>
    <br /><br />
    Login<br />
    <input type="text" name="login" value="<?= $obj->login ?>" maxlength="100" /><br /><br />
    Senha<br />
    <input type="text" name="senha" value="<?= $obj->senha ?>" maxlength="100" /><br /><br />
    Superior<br /> 
    <input type="text" name="superior" value="<?= $obj->superior ?>" maxlength="100" /><br /><br />
    
    
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>