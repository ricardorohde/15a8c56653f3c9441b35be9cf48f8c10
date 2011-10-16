<?
include("../../include/header.php");

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("Restaurante");

$cidades = Cidade::all(array("order" => "nome asc"));
$administradores = Administrador::all(array("order" => "nome asc"));
?>

<h2>Gerenciar Restaurantes</h2>

<a href="admin/restaurante/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/restaurante/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Nome<br />
    <input type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br /><br />
    Cidade<br /> <? if($obj->id_cidade){ 
         echo $obj->cidade->nome;  
      }else{ ?>
        <select name="id_cidade">
            <option value="">-- Selecione --</option>
            <?
            if ($cidades) {
                foreach ($cidades as $cidade) {
                    ?>
                    <option value="<?= $cidade->id ?>" <? if ($cidade->id == $obj->id_cidade) { ?>selected="true"<? } ?>><?= $cidade->nome ?></option>
                <? }
            } ?>
        </select>
    <? } ?>
    <br /><br />
    Endereço<br />
    <input type="text" name="endereco" value="<?= $obj->endereco ?>" maxlength="100" /><br /><br />
    Ativo<br />
    <input type="radio" name="ativo" value="1" <? if (!$obj->id || $obj->ativo === 1) { ?>checked="true"<? } ?> />Sim
    <input type="radio" name="ativo" value="0" <? if ($obj->id && $obj->ativo === 0) { ?>checked="true"<? } ?> />Não
    <br /><br />
    Administrador que cadastrou<br />
    <select name="id_administrador_cadastrou">
	<option value="">-- Selecione --</option>
	<?
	if ($administradores) {
	    foreach ($administradores as $adm) {
		?>
		<option value="<?= $adm->id ?>" <? if ($adm->id == $obj->id_administrador_cadastrou) { ?>selected="true"<? } ?>><?= $adm->nome ?></option>
	    <? }
	} ?>
    </select><br /><br />
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>