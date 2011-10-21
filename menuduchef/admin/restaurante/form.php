<?
include("../../include/header.php");

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("Restaurante");

$cidades = Cidade::all(array("order" => "nome asc"));
$administradores = Administrador::all(array("order" => "nome asc"));

$tipos = TipoRestaurante::all();
$tipos_produto = TipoProduto::all();
$bairros = Bairro::all();
?>
<script type="text/javascript">
    $(function() {
        
        <? if($obj->id){ ?>
            autoCompleteBairrosCheckBox(<?= $obj->cidade_id ?>, <?= $obj->id ?>);          
        <? } ?>

	    
	$('#cidades').change(function() {
	    autoCompleteBairrosCheckBox($(this).val());
	});
    });
</script>
<h2>Gerenciar Restaurantes</h2>

<a href="admin/restaurante/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/restaurante/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Nome<br />
    <input type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br /><br />
    Cidade<br /> <? if($obj->cidade_id){ 
         echo $obj->cidade->nome;
         echo "<input type='hidden' id='cidades' value='".$obj->cidade_id."'>";
      }else{ ?>
        <select id="cidades" name="cidade_id">
            <option value="">-- Selecione --</option>
            <?
            if ($cidades) {
                foreach ($cidades as $cidade) {
                    ?>
                    <option value="<?= $cidade->id ?>" <? if ($cidade->id == $obj->cidade_id) { ?>selected="true"<? } ?>><?= $cidade->nome ?></option>
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
    <select name="administrador_cadastrou_id">
	<option value="">-- Selecione --</option>
	<?
	if ($administradores) {
	    foreach ($administradores as $adm) {
		?>
		<option value="<?= $adm->id ?>" <? if ($adm->id == $obj->administrador_cadastrou_id) { ?>selected="true"<? } ?>><?= $adm->nome ?></option>
	    <? }
	} ?>
    </select><br /><br />    
    Bairros que o restaurante atende<br />
    <div id="bairros"></div>
    <br />
    
    <? if($tipos) { ?>
    
    Categorias de restaurante<br />
    
    <? foreach($tipos as $tipo) { ?>
    
    <input type="checkbox" name="tipo_id" value="<?= $tipo->id ?>" id="tipo_<?= $tipo->id ?>" />
    <label for="tipo_<?= $tipo->id ?>"><?= $tipo->nome ?></label><br />
    
    <? } ?>
    <br />
    <? } ?>
    <? if($tipos_produto) { ?>
    
    Categorias de produtos<br />
    
    <? foreach($tipos_produto as $tipo_produto) { ?>
    
    <input type="checkbox" name="tipo_produto_id" value="<?= $tipo_produto->id ?>" id="tipo_produto_<?= $tipo_produto->id ?>" />
    <label for="tipo_produto_<?= $tipo_produto->id ?>"><?= $tipo_produto->nome ?></label><br />
    
    <? } ?>
    <br />
    <? } ?>
    
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>