<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("Restaurante");

$cidades = Cidade::all(array("order" => "nome asc"));
$administradores = Administrador::all(array("order" => "nome asc"));

$tipos = TipoRestaurante::all();
$tipos_produto = TipoProduto::all();
$bairros = Bairro::all();
$formasPagamento = FormaPagamento::all();

$now = time();
$hash_restaurante = 'restaurante' . $now;

$horariosJson = StringUtil::arrayActiveRecordToJson($obj->horarios, array('methods' => array('hash', '__toString')));
$_SESSION[$hash_restaurante] = json_decode($horariosJson, true);
?>

<script type="text/javascript">
    $(function() {
        
        <? if($obj->id){ ?>
            autoCompleteBairrosCheckBox(<?= $obj->cidade_id ?>, <?= $obj->id ?>);          
        <? } ?>

	    
	$('#cidades').change(function() {
	    autoCompleteBairrosCheckBox($(this).val());
	});
	
	listHorariosRestaurante(<?= $horariosJson ?>, 'horarios', '<?= $hash_restaurante ?>');
	
	var imgLoading = new Image();
	imgLoading.src = '<?= PATH_IMAGE_LOADING ?>';
	
	$('#add_horario_restaurante').click(function() {
            $('#form_horario_restaurante').dialog('open');
        });
	
	$('#form_horario_restaurante').dialog({
            autoOpen: false,
            modal: true,
            width: '25%',
            resizable: false,
            buttons: {
                'Salvar': function() {
                    addHorarioRestaurante($('input, select, textarea', this).serializeArray(), 'horarios', '<?= $hash_restaurante ?>', imgLoading);
                },
                'Cancelar': function () {
                    $(this).dialog('close');
                }
            },
            open: function() {
                var isUpdate = parseInt($(this).dialog('option', 'isUpdate'));
                var attributes = $(this).dialog('option', 'attributes');
		
                if(isUpdate) {
                    $(this).populateForm(attributes);
                }
            },
            close: function() {
                $(this).clearFormElements();
                $(this).dialog('option', 'isUpdate', null);
                $(this).dialog('option', 'attributes', null);
                $('#mensagens_horario_restaurante').empty();
            }
        });
    });
</script>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Restaurantes</h2>

<a href="admin/restaurante/" title="Cancelar">Cancelar</a>

<form action="admin/restaurante/controller" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    <input type="hidden" id="hash_restaurante" name="hash_restaurante" value="<?= $hash_restaurante ?>" />
    
    <label class="normal">Nome:</label>
    <input class="formfield w50" type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" />
    
    <label class="normal">Foto:</label>
    <input class="formfield w50" type="file" name="imagem" maxlength="100" />
    <? if($obj->imagem) { ?>
    <br clear="all" /><img src="<?= $obj->getUrlImagem() ?>" class="left" alt="<?= $obj->nome ?>" />
    <a href="admin/php/controller/exclude_image" class="left bold red" onclick="return confirm('Excluir imagem?')">X</a>
    <? } ?>
    
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
                    <option value="<?= $cidade->id ?>" <? if ($cidade->id == $obj->cidade_id) { ?>selected="selected"<? } ?>><?= $cidade->nome ?></option>
                <? }
            } ?>
        </select>
    <? } ?>

    <label class="normal">Endereço:</label>
    <input class="formfield w50" type="text" name="endereco" value="<?= $obj->endereco ?>" maxlength="100" /><br /><br />
    
    <label class="normal">Horários:</label>
    <a id="add_horario_restaurante" class="left w100 bottom10" href="javascript:void(0)">Adicionar</a>
    <br /><br />
    <div id="form_horario_restaurante" title="Adicionar horário">
        <div id="mensagens_horario_restaurante"></div>
        <input type="hidden" id="horario_id" name="horario_id" value="" />
        <input type="hidden" name="hash" value="" />
	<label for="dia_da_semana" class="normal">Dias da semana:</label>
        <input class="formfield w90" type="text" id="dia_da_semana" name="dia_da_semana" maxlength="50" />
        
        <label class="normal">1º horário:</label>
        <input class="left w40" type="text" id="hora_inicio1" maxlength="5" name="hora_inicio1" onkeyup="mask_hora(this)" />
        <span class="adjacent">&nbsp;até&nbsp;</span>
        <input class="left w40" type="text" id="hora_fim1" maxlength="5" name="hora_fim1" onkeyup="mask_hora(this)" />
        
        <label class="normal">2º horário:</label>
        <input class="left w40" type="text" id="hora_inicio2" maxlength="5" name="hora_inicio2" onkeyup="mask_hora(this)" />
        <span class="adjacent">&nbsp;até&nbsp;</span>
        <input class="left w40" type="text" id="hora_fim2" maxlength="5" name="hora_fim2" onkeyup="mask_hora(this)" />
        
        <label class="normal">3º horário:</label>
        <input class="left w40" type="text" id="hora_inicio3" maxlength="5" name="hora_inicio3" onkeyup="mask_hora(this)" />
        <span class="adjacent">&nbsp;até&nbsp;</span>
        <input class="left w40" type="text" id="hora_fim3" maxlength="5" name="hora_fim3" onkeyup="mask_hora(this)" />
    </div>
    <table class="list w50" id="horarios">
        <tr>
	    <th>Horários</th>
            <th width="10%"></th>
            <th width="10%"></th>
        </tr>
    </table>
    
    <label class="normal">Ativo:</label>
    <input class="adjacent" id="ativo_sim" type="radio" name="ativo" value="1" <? if (!$obj->id || $obj->ativo === 1) { ?>checked="checked"<? } ?> />
    <label class="adjacent" for="ativo_sim">Sim</label>
    <input class="adjacent" id="ativo_nao" type="radio" name="ativo" value="0" <? if ($obj->id && $obj->ativo === 0) { ?>checked="checked"<? } ?> />
    <label class="adjacent" for="ativo_nao">Não</label>
    
    <label class="normal">Pizzas podem ser divididas em quantos sabores (&uacute;til apenas para quem vende pizzas):</label>
    <select class="formfield w20" name="qtd_max_sabores">
	<option value="">-- Selecione --</option>
	
	<option value="2" <? if (2 == $obj->qtd_max_sabores) { ?>selected="selected"<? } ?>>2</option>
        <option value="3" <? if (3 == $obj->qtd_max_sabores) { ?>selected="selected"<? } ?>>3</option>
        <option value="4" <? if (4 == $obj->qtd_max_sabores) { ?>selected="selected"<? } ?>>4</option>
    </select>
	
    <label class="normal">Administrador que cadastrou:</label>
    <select class="formfield w40" name="administrador_cadastrou_id">
	<option value="">-- Selecione --</option>
	<?
	if ($administradores) {
	    foreach ($administradores as $adm) {
		?>
		<option value="<?= $adm->id ?>" <? if ($adm->id == $obj->administrador_cadastrou_id) { ?>selected="selected"<? } ?>><?= $adm->nome ?></option>
	    <? }
	} ?>
    </select>

    <label class="normal">Bairros que o restaurante atende:</label>
    <div id="bairros"></div>
    
    <? if($tipos) { ?>
    
    <label class="normal">Categorias de restaurante:</label>
    
    <? foreach($tipos as $tipo) { ?>
    
    <input class="adjacent" type="checkbox" name="tipos[]" value="<?= $tipo->id ?>" id="tiporestaurante_id_<?= $tipo->id ?>" <? if($obj->temTipo($tipo->id)) { ?>checked="checked"<? } ?> />
    <label class="adjacent" for="tiporestaurante_id_<?= $tipo->id ?>"><?= $tipo->nome ?></label>
    
    <? } } ?>
    
    <? if($tipos_produto) { ?>
    
    <label class="normal">Categorias de produtos:</label>
    
    <? foreach($tipos_produto as $tipo_produto) { ?>
    
    <input class="adjacent" type="checkbox" name="tipos_produto[]" value="<?= $tipo_produto->id ?>" id="tipo_produto_<?= $tipo_produto->id ?>" <? if($obj->temTipoProduto($tipo_produto->id)) { ?>checked="checked"<? } ?> />
    <label class="adjacent" for="tipo_produto_<?= $tipo_produto->id ?>"><?= $tipo_produto->nome ?></label>
    
    <? } } ?>
    
    <? if($formasPagamento) { ?>
    
    <label class="normal">Formas de pagamento aceitas:</label>
    
    <? foreach($formasPagamento as $forma) { ?>
    
    <input class="adjacent" type="checkbox" name="formas_pagamento[]" value="<?= $forma->id ?>" id="formapagamento_id_<?= $forma->id ?>" <? if($obj->temFormaPagamento($forma->id)) { ?>checked="checked"<? } ?> />
    <label class="adjacent" for="formapagamento_id_<?= $forma->id ?>"><?= $forma->nome ?></label>
    
    <? } } ?>
    
    <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer_admin.php"); ?>