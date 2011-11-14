<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("Consumidor");

$cidades = Cidade::all(array("order" => "nome asc"));
$hash = 'consumidor' . time();
?>

<script type="text/javascript">
//    $(function() {
//	$('#cidades').change(function() {
//	    autoCompleteBairros($(this).val());
//	});
//    });

    var current_t = <?= $obj->telefones ? (sizeof($obj->telefones) + 1) : 1 ?>;

    function addInput_t(suffix) {
	$('#telInput').append($(
	'<div id="input' + suffix + '">'
	    + '<input class="formfield w15" name="telefone' + suffix + '" type="text" size="20" />'
	    + (suffix > 1 ? ' <label class="adjacent bold" onclick="this.parentNode.parentNode.removeChild(this.parentNode)">X</label>' : '')
	    + '</div>'
    ));
    }

    $(function() {
	addInput_t(current_t);
	$('#addPagina_t').click(function() {
	    addInput_t(++current_t);
	});
    });

    var current_e = <?= $obj->enderecos ? (sizeof($obj->enderecos) + 1) : 1 ?>;

    function addInput_e(suffix) {
	$('#endInput').append($(
	'<div id="input' + suffix + '">'
	    + '   <select name="cidade' + suffix + '" type="text"  ></select>'
	    + '   <select name="bairro' + suffix + '" type="text"  ></select>'
	    + '   <input name="logradouro' + suffix + '" type="text" size="20" />'
	    + (suffix > 1 ? ' <label class="adjacent bold" onclick="this.parentNode.parentNode.removeChild(this.parentNode)">X</label>' : '')
	    + '</div>'
    ));
    }

    $(function() {
	addInput_e(current_e);
	
	$('#addPagina_e').click(function() {
	    addInput_e(++current_e);
	});
	
	$('#add_endereco').click(function() {
	   $('#form_endereco').dialog('open');
	});
	
	$('.modificar_endereco').click(function() {
	    
	});
	
	var imgLoading = new Image();
	imgLoading.src = '<?= PATH_IMAGE_LOADING ?>';

	$('#form_endereco').dialog({
	    autoOpen: false,
	    modal: true,
	    width: '40%',
	    resizable: false,
	    buttons: {
		'Adicionar endereço': function() {
		    addEnderecoConsumidor($('input, select, textarea', this).add('#hash').serializeArray(), 'enderecos', imgLoading);
		},
		'Cancelar': function () {
		    $(this).dialog('close');
		}
	    },
	    open: function() {
		autoCompleteBairros($('#cidade_endereco').val(), 'bairro_endereco');
		
		$('#cidade_endereco').change(function() {
		    autoCompleteBairros($(this).val(), 'bairro_endereco');
		});
	    },
	    close: function() {
		clearFormElements(this);
		$('#mensagens_endereco').empty();
	    }
	});
    });
</script>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Clientes</h2>

<a href="admin/consumidor/" title="Cancelar">Cancelar</a>

<form action="admin/consumidor/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    <input type="hidden" id="hash" name="hash" value="<?= $hash ?>" />
    
    <label class="normal">Nome:</label>
    <input class="formfield w50" type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" />

    <label class="normal">CPF:</label>
    <input class="formfield w15" type="text" name="cpf" value="<?= $obj->cpf ?>" maxlength="100" />

    <label class="normal">Data de Nascimento:</label>
    <input class="formfield w15" type="text" name="data_nascimento" value="<?= $obj->data_nascimento ?>" maxlength="100" />

    <label class="normal">Sexo:</label>
    <input class="formfield w15" type="text" name="sexo" value="<?= $obj->sexo ?>" maxlength="100" />

    <label class="normal">Telefones:</label>
    <div class="left w100" id="telInput">
	<?
	if ($obj->telefones) {
	    $telc = 1;
	    foreach ($obj->telefones as $tel) {
		?>
		<div><input class="formfield w15" type="text" name="telefone<?= $telc ?>" value="<?= $tel->numero ?>" maxlength="100" /> <label class="adjacent bold" onclick="this.parentNode.parentNode.removeChild(this.parentNode)">X</label></div>
		<?
		$telc++;
	    }
	}
	?>
    </div>
    <input class="btn" type="button" value="  +  " id="addPagina_t" />
    
    <label class="normal">Endereços:</label>
    <a id="add_endereco" class="left w100 bottom10" href="javascript:void(0)">Adicionar</a>
    <br /><br />
    <div id="form_endereco" title="Adicionar endereço">
	<div id="mensagens_endereco"></div>
	
	<label for="cidade_endereco" class="normal">Cidade:</label>
	
	<select class="w80 formfield" id="cidade_endereco" name="cidade_id">
	    <option value="">-- Selecione --</option>
	    <? if($cidades) foreach($cidades as $cidade) { ?>
	    <option value="<?= $cidade->id ?>"><?= $cidade->nome ?></option>
	    <? } ?>
	</select>
	
	<label for="bairro_endereco" class="normal">Bairro:</label>
	<select class="w80 formfield" id="bairro_endereco" name="bairro_id"></select>
	
	<label for="logradouro_endereco" class="normal">Logradouro:</label>
	<input class="formfield w90" type="text" id="logradouro_endereco" name="logradouro" />
	
	<label for="numero_endereco" class="normal">Número:</label>
	<input class="formfield w15" type="text" id="numero_endereco" name="numero" />
	
	<label for="complemento_endereco" class="normal">Complemento:</label>
	<input class="formfield w25" type="text" id="complemento_endereco" name="complemento" />
	
	<label for="cep_endereco" class="normal">CEP:</label>
	<input class="formfield w25" type="text" id="cep_endereco" name="cep" />
	
	<input class="adjacent clear-left top10" type="checkbox" id="checkbox_endereco_favorito" name="favorito" value="1" />
	<label class="adjacent top10" for="checkbox_endereco_favorito">Atribuir como endereço favorito</label>
    </div>
    
    <table class="list" id="enderecos">
	<tr>
	    <th>Logradouro</th>
	    <th>Cidade</th>
	    <th>Bairro</th>
	    <th>Número</th>
	    <th>Complemento</th>
	    <th>CEP</th>
	    <th>Favorito</th>
	    <th></th>
	    <th></th>
	</tr>
	<? if ($obj->enderecos) {
	    foreach($obj->enderecos as $endereco) {
	?>
	<tr>
	    <input type="hidden" name="hash_endereco" value="<?= $endereco->hash() ?>" />
	    <td><?= $endereco->logradouro ?></td>
	    <td><?= $endereco->bairro->cidade->nome ?></td>
	    <td><?= $endereco->bairro->nome ?></td>
	    <td><?= $endereco->numero ?: '---' ?></td>
	    <td><?= $endereco->complemento ?: '---' ?></td>
	    <td><?= $endereco->cep ?></td>
	    <td align="center"><input type="radio" name="endereco_favorito" value="<?= $endereco->hash() ?>" <?= $endereco->favorito ? 'checked="true"' : '' ?> /></td>
	    <td><a href="javascript:void(0)" class="modificar_endereco">Modificar</a></td>
	    <td><a href="javascript:void(0)" class="excluir_endereco">Excluir</a></td>
	</tr>
	<? } } else { ?>
	<tr id="nenhum_endereco"><td colspan="9">Nenhum endereço cadastrado</td></tr>
	<? } ?>
    </table>

    <label class="normal">Ativo:</label>
    <input class="adjacent" type="radio" id="ativo_sim" name="ativo" value="1" <? if (!$obj->id || $obj->ativo === 1) { ?>checked="true"<? } ?> />
    <label for="ativo_sim" class="adjacent">Sim</label>
    <input class="adjacent" type="radio" id="ativo_nao" name="ativo" value="0" <? if ($obj->id && $obj->ativo === 0) { ?>checked="true"<? } ?> />
    <label for="ativo_nao" class="adjacent">Não</label>

    <? include("../../include/inputs_email_senha.php"); ?>

    <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer_admin.php"); ?>