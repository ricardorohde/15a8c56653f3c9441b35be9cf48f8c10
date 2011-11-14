<?
include('../../include/header_admin.php');

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

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Restaurantes</h2>

<a href="admin/restaurante/" title="Cancelar">Cancelar</a>

<form action="admin/restaurante/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    
    <label class="normal">Nome:</label>
    <input class="formfield w50" type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" />
    
    <label class="normal">Cidade:</label>
    <? if($obj->cidade_id) { ?>
	<label class="adjacent"><?= $obj->cidade->nome ?></label>
        <input type="hidden" id="cidades" value="<?= $obj->cidade_id ?>" />
    <? } else { ?>
        <select class="formfield w40" id="cidades" name="cidade_id">
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

    <label class="normal">Endereço:</label>
    <input class="formfield w50" type="text" name="endereco" value="<?= $obj->endereco ?>" maxlength="100" /><br /><br />
    
    <label class="normal">Ativo:</label>
    <input class="adjacent" id="ativo_sim" type="radio" name="ativo" value="1" <? if (!$obj->id || $obj->ativo === 1) { ?>checked="true"<? } ?> />
    <label class="adjacent" for="ativo_sim">Sim</label>
    <input class="adjacent" id="ativo_nao" type="radio" name="ativo" value="0" <? if ($obj->id && $obj->ativo === 0) { ?>checked="true"<? } ?> />
    <label class="adjacent" for="ativo_nao">Não</label>
    
    <label class="normal">Pizzas podem ser divididas em quantos sabores (&uacute;til apenas para quem vende pizzas):</label>
    <select class="formfield w20" name="qtd_max_sabores">
	<option value="">-- Selecione --</option>
	
	<option value="2" <? if (2 == $obj->qtd_max_sabores) { ?>selected="true"<? } ?>>2</option>
        <option value="3" <? if (3 == $obj->qtd_max_sabores) { ?>selected="true"<? } ?>>3</option>
        <option value="4" <? if (4 == $obj->qtd_max_sabores) { ?>selected="true"<? } ?>>4</option>
    </select>
	
    <label class="normal">Administrador que cadastrou:</label>
    <select class="formfield w40" name="administrador_cadastrou_id">
	<option value="">-- Selecione --</option>
	<?
	if ($administradores) {
	    foreach ($administradores as $adm) {
		?>
		<option value="<?= $adm->id ?>" <? if ($adm->id == $obj->administrador_cadastrou_id) { ?>selected="true"<? } ?>><?= $adm->nome ?></option>
	    <? }
	} ?>
    </select>

    <label class="normal">Bairros que o restaurante atende:</label>
    <div id="bairros"></div>
    
    <? if($tipos) { ?>
    
    <label class="normal">Categorias de restaurante:</label>
    
    <? foreach($tipos as $tipo) { ?>
    
    <input class="adjacent" type="checkbox" name="tipos[]" value="<?= $tipo->id ?>" id="tiporestaurante_id_<?= $tipo->id ?>" <? if($obj->temTipo($tipo->id)) { ?>checked="true"<? } ?> />
    <label class="adjacent" for="tiporestaurante_id_<?= $tipo->id ?>"><?= $tipo->nome ?></label>
    
    <? } } ?>
    
    <? if($tipos_produto) { ?>
    
    <label class="normal">Categorias de produtos:</label>
    
    <? foreach($tipos_produto as $tipo_produto) { ?>
    
    <input class="adjacent" type="checkbox" name="tipos_produto[]" value="<?= $tipo_produto->id ?>" id="tipo_produto_<?= $tipo_produto->id ?>" <? if($obj->temTipoProduto($tipo_produto->id)) { ?>checked="true"<? } ?> />
    <label class="adjacent" for="tipo_produto_<?= $tipo_produto->id ?>"><?= $tipo_produto->nome ?></label>
    
    <? } } ?>
    
    <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer_admin.php"); ?>