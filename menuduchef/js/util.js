/**
 * Requires jQuery
 */
var COMBO_BOX_DEFAULT_OPTION = '<option value="">-- Selecione --</option>';
var COMBO_BOX_DEFAULT_ENDERECO = '<option value="">-- Selecione um cliente primeiro --</option>';
var COMBO_BOX_DEFAULT_BAIRRO = '<option value="">-- Selecione uma cidade primeiro --</option>';
var COMBO_BOX_DEFAULT_PRODUTO = '<option value="">-- Selecione um pedido primeiro --</option>';
var COMBO_BOX_LOADING_OPTION = '<option value="">Carregando...</option>';
var CHECK_BOX_LOADING_OPTION = 'Carregando...';
var CHECK_BOX_DEFAULT_OPTION = '';
var URL_BAIRROS_JSON = 'php/controller/list_bairros_json';
var URL_ENDERECOS_JSON = 'php/controller/list_enderecos_json';
var URL_PRODUTOS_JSON = 'php/controller/list_produtos_json';
var URL_PRODUTOS_ADICIONAIS_JSON = 'php/controller/list_produtos_adicionais_json';
var URL_PRODUTO_SEGUNDO_SABOR = 'php/controller/list_segundo_sabor_json';
var AREA_MODIFICAR_SENHA_ID = 'areaModificarSenha';

function isEmpty(data) {
    return data == null || data.length == 0;
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

function autoCompleteSegundoSabor(idProduto) {
    if(idProduto) {
	autoShow(URL_PRODUTO_SEGUNDO_SABOR, {'id': idProduto}, 'sabor_extra');
    } else {
		
	$('#sabor_extra').hide();
    }
}

function autoShow(url, parameters, targetId) {
    var target = $('#' + targetId);
    $.getJSON(url, parameters, function(data) {
	if(!isEmpty(data)) {
	    target.show();
	} else {
	    target.hide();
	}
    });
}

function autoCompleteEnderecos(idConsumidor, preSelectedIdEndereco) {
    if(idConsumidor) {
	autoCompleteComboBox(URL_ENDERECOS_JSON, {
	    'id': idConsumidor
	}, 'enderecos', 'id', 'logradouro', preSelectedIdEndereco);
    } else {
	$('#enderecos').empty().append($(COMBO_BOX_DEFAULT_ENDERECO));
    }
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
		$.getJSON('php/controller/restaurante_atende_bairro_json.php', {
		    'restaurante_id': idRestaurante, 
		    'bairro_id': value.id
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

function autoCompleteProdutosAdicionaisCheckBox(idRestaurante, idProduto) {
    var target = $('#adicionais');

    if(idRestaurante) {
	target.empty().append($(CHECK_BOX_LOADING_OPTION));

	$.getJSON(URL_PRODUTOS_ADICIONAIS_JSON, {
	    'id': idRestaurante
	}, function(data) {
	    if(data.length) {
		target.empty().append($(CHECK_BOX_DEFAULT_OPTION));

		$.each(data, function(i, value) {
		
		    var produtoTemAdicional = false;
		
		    $.each(value.produto_tem_produtos_adicionais, function(j, ppa) {
			if(!produtoTemAdicional && ppa.produto_id == idProduto) {
			    produtoTemAdicional = true;
			}
		    });
		
		    target.append($('<input type="checkbox" name="produtos_adicionais[]" value="' + value.id + '" id="produto_adicional' + value.id + '" ' + (produtoTemAdicional ? 'checked="true"' : '') + ' />'));
		    target.append($('<label for="produto_adicional' + value.id + '">' + value.nome + '</label>'));
		    target.append($('<br />'));
		});
	    } else {
		target.empty().text('O restaurante não disponibiliza adicionais');
	    }
	});
    } else {
	target.empty().text('Escolha um restaurante primeiro');
    }
}

function autoCompleteProdutosCheckBox(idRestaurante) { //seinao ainda
    var target = $('#produtos');

    if(idRestaurante) {
	target.empty().append($(CHECK_BOX_LOADING_OPTION));

	$.getJSON(URL_PRODUTOS_JSON, {
	    'id': idRestaurante
	}, function(data) {
	    if(data.length) {
		target.empty().append($(CHECK_BOX_DEFAULT_OPTION));

		$.each(data, function(i, value) {
		
		    var produto = false;
			
		    target.append($('<select name="produtos_adicionais[]" value="' + value.id + '" id="produto' + value.id + '" >'));
		    target.append($('<label for="produto' + value.id + '">' + value.nome + '</select>'));
		    target.append($('<br />'));
		});
	    } else {
		target.empty().text('O restaurante não disponibiliza itens');
	    }
	});
    } else {
	target.empty().text('Escolha um restaurante primeiro');
    }
}