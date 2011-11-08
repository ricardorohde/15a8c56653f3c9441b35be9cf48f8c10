/**
 * Requires jQuery
 */
var AREA_MODIFICAR_SENHA_ID = 'areaModificarSenha';
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
var URL_ENDERECO_CONSUMIDOR = 'php/controller/add_endereco_consumidor';

function isEmpty(data) {
    return data == null || data == '' || data.length == 0;
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
                    contentOption += ' selected="true"';
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
                    target.append($('<input class="adjacent clear-left top10" type="checkbox" name="bairros[]" value="' + key.id + '" id="bairro' + key.id + '" ' + (atende ? 'checked="true"' : '') + ' />'));
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
		
                    target.append($('<input class="adjacent" type="checkbox" name="produtos_adicionais[]" value="' + key.id + '" id="produto_adicional' + key.id + '" ' + (produtoTemAdicional ? 'checked="true"' : '') + ' />'));
                    target.append($('<label class="adjacent" for="produto_adicional' + key.id + '">' + key.nome + '</label>'));
                    target.append($('<br />'));
                });
            } else {
                target.empty().html('<label class="adjacent">O restaurante não disponibiliza adicionais</label>');
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
                target.empty().html('<label class="adjacent">O restaurante não disponibiliza itens</label>');
            }
        });
    } else {
        target.empty().html('<label class="adjacent">Escolha um restaurante primeiro</label>');
    }
}

function addEnderecoConsumidor(parameters, tableId) {
    $.post(URL_ENDERECO_CONSUMIDOR, parameters, function(data) {
	if(!isEmpty(data)) {
	    $('#nenhum_endereco').remove();
	    var row = '<tr>';
	    row += '<td>' + data.logradouro + '</td>';
	    row += '<td>' + data.bairro.cidade.nome + '</td>';
	    row += '<td>' + data.bairro.nome + '</td>';
	    row += '<td>' + 0 + '</td>';
	    row += '<td><input type="radio" name="favorito" ' + (data.favorito ? 'checked="true"' : '') + ' /></td>';
	    row += '<td><a href="javascript:void(0)" class="excluir">Excluir</a></td>';
	    row += '</tr>';

	    $('#' + tableId).append($(row));
	}
    }, 'json');
}

function clearFormElements(context) {
    $('input, select, textarea', context).val(null).removeAttr('checked');
}