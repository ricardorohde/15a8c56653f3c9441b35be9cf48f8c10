/**
 * Requires jQuery
 */
var COMBO_BOX_DEFAULT_OPTION = '<option value="">-- Selecione --</option>';
var COMBO_BOX_DEFAULT_BAIRRO = '<option value="">-- Selecione uma cidade primeiro --</option>';
var COMBO_BOX_DEFAULT_PRODUTO = '<option value="">-- Selecione um pedido primeiro --</option>';
var COMBO_BOX_LOADING_OPTION = '<option value="">Carregando...</option>';
var CHECK_BOX_LOADING_OPTION = 'Carregando...';
var CHECK_BOX_DEFAULT_OPTION = '';
var URL_BAIRROS_JSON = 'php/controller/list_bairros_json';
var URL_PRODUTOS_JSON = 'php/controller/list_produtos_json';
var AREA_MODIFICAR_SENHA_ID = 'areaModificarSenha';

function autoCompleteComboBox(url, parameters, targetId, valueIndex, descriptionIndex, preSelectedValue) {
    var target = $('#' + targetId);
    target.empty().append($(COMBO_BOX_LOADING_OPTION));
    
    $.getJSON(url, parameters, function(data) {
	if(data.length) {
	    target.empty().append($(COMBO_BOX_DEFAULT_OPTION));
	    
	    $.each(data, function(i, value) {
		target.append($(
		    '<option value="' + value[valueIndex] + '"' +
		    (preSelectedValue && (preSelectedValue == value[valueIndex]) ? ' selected="true"' : '') + '>' +
		    value[descriptionIndex] +
		    '</option>'
		    ));
	    });
	} else {
	    target.empty().append($(COMBO_BOX_DEFAULT_OPTION));
	}
    });
}

function autoCompleteBairros(idCidade, preSelectedIdBairro) {
    if(idCidade) {
	autoCompleteComboBox(URL_BAIRROS_JSON, {
	    'id': idCidade
	}, 'bairros', 'id', 'nome', preSelectedIdBairro);
    } else {
	$('#bairros').empty().append($(COMBO_BOX_DEFAULT_BAIRRO));
    }
}

function autoCompleteProdutos(idRestaurante, preSelectedIdProduto) {
    if(idRestaurante) {
	autoCompleteComboBox(URL_PRODUTOS_JSON, {
	    'id': idRestaurante
	}, 'produtos', 'id', 'nome', preSelectedIdProduto);
    } else {
		
	$('#produtos').empty().append($(COMBO_BOX_DEFAULT_PRODUTO));
    }
}

function permitirModificarSenha() {
    if($(this).attr('checked')) {
	$('#' + AREA_MODIFICAR_SENHA_ID).show();
    } else {
	$('#' + AREA_MODIFICAR_SENHA_ID).hide();
    }
}


function autoCompleteBairrosCheckBox(idCidade, idRestaurante) {
    var target = $('#bairros');
    target.empty().append($(CHECK_BOX_LOADING_OPTION));

    $.getJSON(URL_BAIRROS_JSON, {
	'id': idCidade
    }, function(data) {
	if(data.length) {
	    target.empty().append($(CHECK_BOX_DEFAULT_OPTION));

	    $.each(data, function(i, value) {
		$.getJSON("php/controller/restaurante_atende_bairro_json.php", {
		    "restaurante_id": idRestaurante, 
		    "bairro_id": value.id
		}, function(atende) {
		    target.append($('<input type="checkbox" name="bairros[]" value="' + value.id + '" id="bairro' + value.id + '" ' + (atende ? 'checked="true"' : '') + ' />'));
		    target.append($('<label for="bairro' + value.id + '">' + value.nome + '</label>'));
		    target.append($(' -- <input type="text" name="preco_entrega[]" value="' + (atende ? atende.preco_entrega : '') + '" id="preco_entrega' + value.id + '" />'));
		    target.append($('<br />'));
		});
	    });

	} else {
	    target.empty().append($(CHECK_BOX_DEFAULT_OPTION));
	}
    });
}