/**
 * Requires jQuery
 */
var AREA_MODIFICAR_SENHA_ID = 'areaModificarSenha';
var ENDERECO_DIALOG_ID = 'form_endereco';
var COMBO_BOX_DEFAULT_OPTION = '<option value="">-- Selecione --</option>';
var COMBO_BOX_DEFAULT_ENDERECO = '<option value="">-- Selecione um cliente e um restaurante primeiro --</option>';
var COMBO_BOX_DEFAULT_BAIRRO = '<option value="">-- Selecione uma cidade primeiro --</option>';
var COMBO_BOX_DEFAULT_PRODUTO = '<option value="">-- Selecione um pedido primeiro --</option>';
var COMBO_BOX_LOADING_OPTION = '<option value="">Carregando...</option>';
var CHECK_BOX_LOADING_OPTION = '<label class="adjacent">Carregando...</label>';
var CHECK_BOX_DEFAULT_OPTION = '';
var URL_BAIRROS_JSON = 'php/controller/list_bairros_json';
var URL_ENDERECOS_JSON = 'php/controller/list_enderecos_json';
var URL_PRODUTOS_JSON = 'php/controller/list_produtos_json';
var URL_PRODUTOS_ADICIONAIS_JSON = 'php/controller/list_produtos_adicionais_json';
var URL_PRODUTO_SEGUNDO_SABOR = 'php/controller/list_segundo_sabor_json';
var URL_ENDERECO_CONSUMIDOR = 'php/controller/endereco_consumidor_json';

function isEmpty(data) {
    return data == null || data == undefined || data == '' || data.length == 0;
}

function autoCompleteComboBox(url, parameters, targetId, valueIndex, descriptionIndex, preSelectedValue, booleanIndex) {
    var target = $('#' + targetId);
    var contentOption;
    target.empty().append($(COMBO_BOX_LOADING_OPTION));
    
    $.getJSON(url, parameters, function(data) {
	if(!isEmpty(data)) {
	    target.empty().append($(COMBO_BOX_DEFAULT_OPTION));
	    
	    $.each(data, function(index, key) {
		contentOption = '<option value="' + key[valueIndex] + '"';
		var preSelected = false;
                
		if(preSelectedValue) {
		    if(preSelectedValue == key[valueIndex]) {
			preSelected = true;
		    }
		} else if(booleanIndex) {
		    if(key[booleanIndex]) {
			preSelected = true;
		    }
		}
                
		if(preSelected) {
		    contentOption += ' selected="selected"';
		}
                
		contentOption += '>' + key[descriptionIndex] + '</option>';
		target.append($(contentOption));
	    });
	} else {
	    target.empty().append($(COMBO_BOX_DEFAULT_OPTION));
	}
    });
}

function autoCompleteSegundoSabor(idProduto) {
    if(idProduto) {
	autoShow(URL_PRODUTO_SEGUNDO_SABOR, {
	    'id': idProduto
	}, 'sabor_extra');
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

function autoCompleteEnderecos(idConsumidor, idRestaurante, preSelectedIdEndereco) {
    if(idConsumidor && idRestaurante) {
	autoCompleteComboBox(URL_ENDERECOS_JSON, {
	    'idConsumidor': idConsumidor,
	    'idRestaurante': idRestaurante
	}, 'enderecos', 'id', 'logradouro', preSelectedIdEndereco, 'favorito');
        
	$('#enderecos').removeAttr('disabled');
    } else {
	$('#enderecos').empty().append($(COMBO_BOX_DEFAULT_ENDERECO)).attr('disabled', true);
    }
}

function autoCompleteBairros(idCidade, comboboxBairrosId, preSelectedIdBairro) {
    if(idCidade) {
	autoCompleteComboBox(URL_BAIRROS_JSON, {
	    'id': idCidade
	}, comboboxBairrosId, 'id', 'nome', preSelectedIdBairro);
    } else {
	$('#' + comboboxBairrosId).empty().append($(COMBO_BOX_DEFAULT_BAIRRO));
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
	if(!isEmpty(data)) {
	    target.empty().append($(CHECK_BOX_DEFAULT_OPTION));

	    $.each(data, function(index, key) {
		$.getJSON('php/controller/restaurante_atende_bairro_json.php', {
		    'restaurante_id': idRestaurante, 
		    'bairro_id': key.id
		}, function(atende) {
		    target.append($('<input class="adjacent clear-left top10" type="checkbox" name="bairros[]" value="' + key.id + '" id="bairro' + key.id + '" ' + (atende ? 'checked="checked"' : '') + ' />'));
		    target.append($('<label class="adjacent top10" for="bairro' + key.id + '">' + key.nome + '</label>'));
		    target.append($('<input class="adjacent" type="text" name="preco_entrega[]" value="' + (atende ? atende.preco_entrega : '') + '" id="preco_entrega' + key.id + '" />'));
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
	    if(!isEmpty(data)) {
		target.empty().append($(CHECK_BOX_DEFAULT_OPTION));

		$.each(data, function(index, key) {
		
		    var produtoTemAdicional = false;
		
		    $.each(key.produto_tem_produtos_adicionais, function(j, ppa) {
			if(!produtoTemAdicional && ppa.produto_id == idProduto) {
			    produtoTemAdicional = true;
			}
		    });
		
		    target.append($('<input class="adjacent" type="checkbox" name="produtos_adicionais[]" value="' + key.id + '" id="produto_adicional' + key.id + '" ' + (produtoTemAdicional ? 'checked="checked"' : '') + ' />'));
		    target.append($('<label class="adjacent" for="produto_adicional' + key.id + '">' + key.nome + '</label>'));
		    target.append($('<br />'));
		});
	    } else {
		target.empty().html('<label class="adjacent">O restaurante n�o disponibiliza adicionais</label>');
	    }
	});
    } else {
	target.empty().html('<label class="adjacent">Escolha um restaurante primeiro</label>');
    }
}

function autoCompleteProdutosCheckBox(idRestaurante) { //seinao ainda
    var target = $('#produtos');

    if(idRestaurante) {
	target.empty().append($(CHECK_BOX_LOADING_OPTION));

	$.getJSON(URL_PRODUTOS_JSON, {
	    'id': idRestaurante
	}, function(data) {
	    if(!isEmpty(data)) {
		target.empty().append($(CHECK_BOX_DEFAULT_OPTION));

		$.each(data, function(index, key) {
		
		    var produto = false;
			
		    target.append($('<select name="produtos_adicionais[]" value="' + key.id + '" id="produto' + key.id + '" >'));
		    target.append($('<label for="produto' + key.id + '">' + key.nome + '</select>'));
		    target.append($('<br />'));
		});
	    } else {
		target.empty().html('<label class="adjacent">O restaurante n�o disponibiliza itens</label>');
	    }
	});
    } else {
	target.empty().html('<label class="adjacent">Escolha um restaurante primeiro</label>');
    }
}

function listEnderecosConsumidor(arrayEnderecos, tableId, hashConsumidor) {
    if(!isEmpty(arrayEnderecos)) {
	$('#' + tableId + ' .row_data').remove();
	$('#add_endereco').data('first', 0); //TODO verificar as ocorr�ncias de uso desse attributo
	
	$.each(arrayEnderecos, function(index, data) {
	    var row = '<tr class="row_data">';
	    row += '<input type="hidden" name="hash_endereco" value="' + data.hash + '" />';
	    row += '<td>' + data.logradouro + '</td>';
	    row += '<td>' + data.bairro.cidade.nome + '</td>';
	    row += '<td>' + data.bairro.nome + '</td>';
	    row += '<td>' + (data.numero ? data.numero : '---') + '</td>';
	    row += '<td>' + (data.complemento ? data.complemento : '---') + '</td>';
	    row += '<td>' + data.cep + '</td>';
	    row += '<td><input type="radio" name="endereco_favorito" value="' + data.hash + '" ' + (data.favorito ? 'checked="checked"' : '') + ' /></td>';
	    row += '<td><a href="javascript:void(0)" class="modificar_endereco">Modificar</a></td>';
	    row += '<td><a href="javascript:void(0)" class="excluir_endereco">Excluir</a></td>';
	    row += '</tr>';

	    var rowElement = $(row).appendTo($('#' + tableId));

	    rowElement.find('.modificar_endereco').click(function() {
                data.endereco_id = data.id;
                data.cidade_id = data.bairro.cidade_id;
                if(!parseInt(data.numero)) {
                    data.numero = null;
                }
                $('#' + ENDERECO_DIALOG_ID).dialog('option', 'isUpdate', 1);
                $('#' + ENDERECO_DIALOG_ID).dialog('option', 'attributes', data);
                $('#' + ENDERECO_DIALOG_ID).dialog('open');
	    });

	    rowElement.find('.excluir_endereco').click(function() {
                $.getJSON(URL_ENDERECO_CONSUMIDOR, {'deleteHash': data.hash, 'favorito': data.favorito, 'hash_consumidor': hashConsumidor}, function(e) {
                    listEnderecosConsumidor(e, tableId, hashConsumidor);
                });
	    });
	});
    } else {
	$('#' + tableId + ' .row_data').remove();
	$('<tr class="row_data"><td colspan="9">Nenhum endere�o cadastrado</td></tr>').appendTo($('#' + tableId));
	$('#add_endereco').data('first', 1);
    }
}

function addEnderecoConsumidor(parameters, tableId, hashConsumidor, imgLoading) {
    $('#mensagens_endereco').empty().append($('<img src="' + imgLoading.src + '" alt="Carregando" title="Carregando" />'));
    var mergedParameters = $.merge(parameters, [{'name': 'hash_consumidor', 'value': hashConsumidor}]);
    
    $.post(URL_ENDERECO_CONSUMIDOR, mergedParameters, function(data) {
	if(!isEmpty(data)) {
	    if(!data.errors) {
		listEnderecosConsumidor(data, tableId, hashConsumidor);
		$('#' + ENDERECO_DIALOG_ID).dialog('close');
	    } else {
		$('#mensagens_endereco').empty();
		$.each(data.errors, function(index, key) {
		    $('#mensagens_endereco').append($('<div class="msg error">&raquo; ' + key.error + '</div>'));
		});
	    }
	}
    }, 'json');
}

$.fn.extend({
    clearFormElements: function() {
	$('input, select, textarea', this).each(function() {
	    switch (this.nodeName.toLowerCase()) {
		case 'select':
		case 'textarea':
		    $(this).val(null);
		    break;
		    
		case 'input':
		    switch (this.type.toLowerCase()) {
			case 'radio':
			case 'checkbox':
			    $(this).removeAttr('checked');
			    break;
			default:
			    $(this).val(null);
			    break;
		    }
	    }
	});
    },
    populateForm: function(fields) {
	var form = this;
	
	$.each(fields, function (name, value) {
            var formattedValue = $("<div/>").html(value).text();
	    $('input[name=' + name + '], textarea[name=' + name + '], select[name=' + name + ']', form).each(function() {
		switch (this.nodeName.toLowerCase()) {
		    case 'textarea':
		    case 'input':
			switch (this.type.toLowerCase()) {
			    case 'radio':
			    case 'checkbox':
				if (this.value == formattedValue) {
				    $(this).click();
				}
				break;
			    default:
				$(this).val(formattedValue);
				break;
			}
			break;
			
		    case 'select':
			$('option', this).each(function(){
			    if (this.value == formattedValue) {
				this.selected = true;
			    }
			});
			break;
		}
	    });
	});
    }
});
