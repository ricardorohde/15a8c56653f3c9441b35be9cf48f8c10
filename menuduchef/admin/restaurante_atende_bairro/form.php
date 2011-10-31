<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("RestauranteAtendeBairro");

$restaurantes = Restaurante::all(array("order" => "nome asc"));
$bairros = Bairro::all(array("order" => "nome asc"));
?>

<h2><a href="admin/">Menu Principal</a> &raquo; Gerenciar Restaurantes atendem Bairros</h2>

<a href="admin/restaurante_atende_bairro/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/restaurante_atende_bairro/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Restaurante<br />
    <select name="id_restaurante">-- Selecione --</option>
	<?
	if ($restaurantes) {
	    foreach ($restaurantes as $restaurante) {
		?>
		<option value="<?= $restaurante->id ?>" <? if ($restaurante->id == $obj->id_restaurante) { ?>selected="true"<? } ?>><?= $restaurante->nome ?></option>
	    <? }
	} ?>
    </select>
    <br /><br />
    Bairro<br />
    <select name="id_bairro">-- Selecione --</option>
	<?
	if ($bairros) {
	    foreach ($bairros as $bairro) {
		?>
		<option value="<?= $bairro->id ?>" <? if ($bairro->id == $obj->id_bairro) { ?>selected="true"<? } ?>><?= $bairro->nome ?></option>
	    <? }
	} ?>
    </select>
    <br /><br />
    Taxa de Entrega<br />
    <input type="text" name="preco_entrega" value="<?= $obj->preco_entrega ?>" maxlength="100" /><br /><br />
        
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>