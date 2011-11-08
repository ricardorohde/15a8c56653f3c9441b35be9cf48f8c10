<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("Consumidor");

$cidades = Cidade::all(array("order" => "nome asc"));
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

	$('#form_endereco').dialog({
	    autoOpen: false,
	    modal: true,
	    width: '40%',
	    resizable: false,
	    buttons: {
		'Adicionar endereço': function() {
		    addEnderecoConsumidor($('input, select, textarea', this).serialize(), 'enderecos');
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
	    }
	});
    });
</script>

<h2><a href="admin/">Menu Principal</a> &raquo; Gerenciar Clientes</h2>

<a href="admin/consumidor/" title="Cancelar">Cancelar</a>

<form action="admin/consumidor/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    <input type="hidden" id="hash" name="hash" value="consumidor<?= time() ?>" />
    
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

    <?/*
    Cidade<br />
    <select id="cidades" name="cidade_id">
	<option value="">-- Selecione --</option>
	<?
	if ($cidades) {
	    $favorito = 0;
	    foreach ($obj->enderecos as $ende) {
		if ($ende->favorito) {
		    $favorito = $ende->bairro_id;
		}
	    }
	    foreach ($cidades as $cidade) {
		?>
		<option value="<?= $cidade->id ?>" <? if ($cidade->id == $favorito) { ?>selected="true"<? } ?>><?= $cidade->nome ?></option>
	    <? }
	} ?>
    </select>
    <br /><br />  
    
    Endere&ccedil;os:<br />
    <div id="endInput">
	<?
	if ($obj->enderecos) {
	    $endc = 1;
	    foreach ($obj->enderecos as $ende) {
		?>
		<div><select name="cidade<?= $endc ?>" type="text"  ></select> <select name="bairro<?= $endc ?>" type="text"  ></select> <input type="text" name="endereco<?= $telc ?>" value="<?= $ende->logradouro ?>" maxlength="100" /> <span onclick="this.parentNode.parentNode.removeChild(this.parentNode)">X</span></div>
		<?
		$endc++;
	    }
	}
	?>
    </div>
    <input type="button" value="  +  " id="addPagina_e" /><br /><br />
    */?>
    
    <label class="normal">Endereços:</label>
    <a id="add_endereco" class="left w100 bottom10" href="javascript:void(0)">Adicionar</a>
    <br /><br />
    <div id="form_endereco" title="Adicionar endereço">
	<label class="normal">Cidade:</label>
	
	<select class="w80 formfield" id="cidade_endereco" name="cidade_id">
	    <option value="">-- Selecione --</option>
	    <? if($cidades) foreach($cidades as $cidade) { ?>
	    <option value="<?= $cidade->id ?>"><?= $cidade->nome ?></option>
	    <? } ?>
	</select>
	
	<label class="normal">Bairro:</label>
	<select class="w80 formfield" id="bairro_endereco" name="bairro_id"></select>
	
	<label class="normal">Logradouro:</label>
	<input class="formfield w90" type="text" name="logradouro" />
	
	<input class="adjacent clear-left top10" type="checkbox" id="checkbox_favorito" name="favorito" value="1" />
	<label class="adjacent top10" for="checkbox_favorito">Atribuir como endereço favorito</label>
    </div>
    
    <table class="list" id="enderecos">
	<tr>
	    <th>Logradouro</th>
	    <th>Cidade</th>
	    <th>Bairro</th>
	    <th>CEP</th>
	    <th>Favorito</th>
	    <th></th>
	</tr>
	<? if ($obj->enderecos) {
	    foreach($obj->enderecos as $endereco) {
	?>
	<tr>
	    <td><?= $endereco->logradouro ?></td>
	    <td><?= $endereco->bairro->cidade->nome ?></td>
	    <td><?= $endereco->bairro->nome ?></td>
	    <td><?= 0 ?></td>
	    <td align="center"><input type="radio" name="favorito" <?= $endereco->favorito ? 'checked="true"' : '' ?> /></td>
	    <td><a href="javascript:void(0)" class="excluir">Excluir</a></td>
	</tr>
	<? } } else { ?>
	<tr><td colspan="6">Nenhum endereço cadastrado</td></tr>
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

<? include("../../include/footer.php"); ?>