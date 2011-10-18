<?
include("../../include/header.php");

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("Bairro");

$cidades = Cidade::all(array("order" => "nome asc"));
?>

<h2>Gerenciar Bairros</h2>

<a href="admin/bairro/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/bairro/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Nome<br />
    <input type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br /><br />
    Cidade<br /> <? if($obj->cidade_id){ 
         echo $obj->cidade->nome;  
      }else{ ?>
        <select name="cidade_id">
            <option value="">-- Selecione --</option>
            <?
            if($cidades) {
                foreach($cidades as $cidade) {
            ?>
            <option value="<?= $cidade->id ?>" <? if($cidade->id == $obj->cidade_id) { ?>selected="true"<? } ?>><?= $cidade->nome ?></option>
            <? } } ?>
        </select>
    <? } ?>
    <br /><br />
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>