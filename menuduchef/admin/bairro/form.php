<?
include("../../include/header.php");

$obj = new Bairro();
$cidades = Cidade::all(array("order" => "nome asc"));

if($_GET["id"]) {
    $obj = Bairro::find($_GET["id"]);
}
?>

<h2>Gerenciar Bairros</h2>

<a href="admin/bairro/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/bairro/controller" method="post">
    <input type="hidden" name="action" value="<?= $obj->id ? "update" : "create" ?>" />
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Nome<br />
    <input type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br /><br />
    Cidade<br />
    <select name="id_cidade">
	<option value="">-- Selecione --</option>
	<?
	if($cidades) {
	    foreach($cidades as $cidade) {
	?>
	<option value="<?= $cidade->id ?>" <? if($cidade->id == $obj->id_cidade) { ?>selected="true"<? } ?>><?= $cidade->nome ?></option>
	<? } } ?>
    </select>
    <br /><br />
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>