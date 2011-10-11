/**
 * Requires jQuery
 */
var COMBO_BOX_DEFAULT_OPTION = '<option value="">-- Selecione --</option>';
var COMBO_BOX_LOADING_OPTION = '<option value="">Carregando...</option>';

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
    autoCompleteComboBox('php/controller/list_bairros_json', {"id": idCidade}, "bairros", "id", "nome", preSelectedIdBairro);
}