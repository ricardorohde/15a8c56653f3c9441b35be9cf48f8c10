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
var URL_RESTAURANTE_ATENDE_BAIRROS_JSON = 'php/controller/list_restaurante_atende_bairros_json';
var URL_PRODUTOS_JSON = 'php/controller/list_pedidos_json';
var AREA_MODIFICAR_SENHA_ID = 'areaModificarSenha';

function autoCompleteCheckBox(url, parameters, targetId, valueIndex, descriptionIndex, preSelectedValue) {
    var target = $('#' + targetId);
    target.empty().append($(CHECK_BOX_LOADING_OPTION));

    $.getJSON(url, parameters, function(data) {

	if(data.length) {
	    target.empty().append($(CHECK_BOX_DEFAULT_OPTION));


	    $.each(data, function(i, value) {
		console.log(value);
		var atende = restauranteAtendeBairro(parameters.id, value[valueIndex]);
		console.log(atende);
		target.append($('<input type="checkbox" name="bairros[]" value="' + value[valueIndex] + '" id="bairro' + value[valueIndex] + '" ' + (atende ? 'checked="true"' : '') + ' />'));
		target.append($('<label for="bairro' + value[valueIndex] + '">' + value[descriptionIndex] + '</label>'));
		target.append($(' -- <input type="text" name="preco_entrega[]" value="' + (atende ? atende.preco_entrega : '') + '" id="preco_entrega' + value[valueIndex] + '" />'));
		target.append($('<br />'));

	    });
	    
	} else {
            
	    target.empty().append($(CHECK_BOX_DEFAULT_OPTION));
	}
    });
    
}

function autoFillCheckBox(url, parameters, targetId, valueIndex, descriptionIndex) {
    var target = $('#' + targetId);
    
    $.getJSON(url, parameters, function(data) {

	if(data.length) {
	    target.empty().append($(CHECK_BOX_DEFAULT_OPTION));

	    $.each(data, function(i, value) {
                
		target.append($('<input type="checkbox" name="bairros[]" value="' + value[valueIndex] + '" id="bairro' + value[valueIndex] + '" />'));
		target.append($('<label for="bairro' + value[valueIndex] + '">' + value[descriptionIndex] + '</label>'));
		target.append($(' -- <input type="text" name="preco_entrega[]" value="" id="preco_entrega' + value[valueIndex] + '" />'));
		target.append($('<br />'));
	    /*target.append($(
		    '<input type="checkbox" value="' + value[valueIndex] + '">' +
		    value[descriptionIndex]
		));*/
	    });
	} else {
            
	    target.empty().append($(CHECK_BOX_DEFAULT_OPTION));
	}
    });
    
}

function autoCompleteBairrosCheckBox(idCidade, preSelectedIdBairro) {
    if(idCidade) {
 
	autoCompleteCheckBox(URL_BAIRROS_JSON, {
	    'id': idCidade
	}, 'bairros', 'id', 'nome', preSelectedIdBairro);

    } else {
	$('#bairros').empty().append($(CHECK_BOX_DEFAULT_BAIRRO));
    }
}
function autoFillBairrosCheckBox(idRestaurante, listaBairros) {
    if(idRestaurante) {
 
	autoFillCheckBox(URL_RESTAURANTE_ATENDE_BAIRROS_JSON, {
	    'id': idRestaurante
	}, 'bairros', 'id', 'nome');

    }
}

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

function restauranteAtendeBairro(idRestaurante, idBairro) {
    $.getJSON("php/controller/restaurante_atende_bairro_json.php", {
	"restaurante_id": idRestaurante, 
	"bairro_id": idBairro
    }, function(data) {
	return data;
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
	alert(idRestaurante);	
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