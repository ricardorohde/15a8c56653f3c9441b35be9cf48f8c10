<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("Consumidor");

$cidades = Cidade::all(array("order" => "nome asc"));
$hash_consumidor = 'consumidor' . time();
$enderecosJson = StringUtil::arrayActiveRecordToJson($obj->enderecos, array('methods' => 'hash', 'include' => array('bairro' => array('include' => 'cidade'))));
$_SESSION[$hash_consumidor] = json_decode($enderecosJson, true);
?>

<script type="text/javascript">
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

        listEnderecosConsumidor(<?= $enderecosJson ?>, 'enderecos', '<?= $hash_consumidor ?>');
        
	var imgLoading = new Image();
	imgLoading.src = '<?= PATH_IMAGE_LOADING ?>';
	
        $('#add_endereco').click(function() {
	    $('#form_endereco').dialog('option', 'first', $(this).data('first'));
            $('#form_endereco').dialog('open');
        });
	
        $('#form_endereco').dialog({
            autoOpen: false,
            modal: true,
            width: '40%',
            resizable: false,
            buttons: {
                'Salvar': function() {
                    addEnderecoConsumidor($('input, select, textarea', this).serializeArray(), 'enderecos', '<?= $hash_consumidor ?>', imgLoading);
                },
                'Cancelar': function () {
                    $(this).dialog('close');
                }
            },
            open: function() {
                var first = parseInt($(this).dialog('option', 'first'));
                var isUpdate = parseInt($(this).dialog('option', 'isUpdate'));
                var attributes = $(this).dialog('option', 'attributes');
		
                if(isUpdate) {
                    $(this).populateForm(attributes);
                }
		
		if(first) {
		    $('#checkbox_endereco_favorito').attr('checked', 'checked');
		}
                
                autoCompleteBairros($('#cidade_endereco').val(), 'bairro_endereco', attributes ? attributes.bairro_id : null);
		
                $('#cidade_endereco').change(function() {
                    autoCompleteBairros($(this).val(), 'bairro_endereco');
                });
            },
            close: function() {
                $(this).clearFormElements();
                $(this).dialog('option', 'isUpdate', null);
                $(this).dialog('option', 'attributes', null);
                $('#mensagens_endereco').empty();
            }
        });
    });
</script>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Clientes</h2>

<a href="admin/consumidor/" title="Cancelar">Cancelar</a>

<form action="admin/consumidor/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    <input type="hidden" id="hash_consumidor" name="hash_consumidor" value="<?= $hash_consumidor ?>" />

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

    <label class="normal">Endere�os:</label>
    <a id="add_endereco" class="left w100 bottom10" href="javascript:void(0)">Adicionar</a>
    <br /><br />
    <div id="form_endereco" title="Adicionar endere�o">
        <div id="mensagens_endereco"></div>

        <input type="hidden" id="endereco_id" name="endereco_id" value="" />
        <input type="hidden" id="hash" name="hash" value="" />

        <label for="cidade_endereco" class="normal">Cidade:</label>

        <select class="w80 formfield" id="cidade_endereco" name="cidade_id">
            <option value="">-- Selecione --</option>
            <? if ($cidades)
                foreach ($cidades as $cidade) { ?>
                    <option value="<?= $cidade->id ?>"><?= $cidade->nome ?></option>
            <? } ?>
        </select>

        <label for="bairro_endereco" class="normal">Bairro:</label>
        <select class="w80 formfield" id="bairro_endereco" name="bairro_id"></select>

        <label for="logradouro_endereco" class="normal">Logradouro:</label>
        <input class="formfield w90" type="text" id="logradouro_endereco" name="logradouro" />

        <label for="numero_endereco" class="normal">N�mero:</label>
        <input class="formfield w15" type="text" id="numero_endereco" name="numero" />

        <label for="complemento_endereco" class="normal">Complemento:</label>
        <input class="formfield w25" type="text" id="complemento_endereco" name="complemento" />

        <label for="cep_endereco" class="normal">CEP:</label>
        <input class="formfield w25" type="text" id="cep_endereco" name="cep" />

        <input class="adjacent clear-left top10" type="checkbox" id="checkbox_endereco_favorito" name="favorito" value="1" />
        <label class="adjacent top10" for="checkbox_endereco_favorito">Atribuir como endere�o favorito</label>
    </div>

    <table class="list w100" id="enderecos">
        <tr>
            <th>Logradouro</th>
            <th>Cidade</th>
            <th>Bairro</th>
            <th>N�mero</th>
            <th>Complemento</th>
            <th>CEP</th>
            <th>Favorito</th>
            <th></th>
            <th></th>
        </tr>
    </table>

    <label class="normal">Ativo:</label>
    <input class="adjacent" type="radio" id="ativo_sim" name="ativo" value="1" <? if (!$obj->id || $obj->ativo === 1) { ?>checked="checked"<? } ?> />
    <label for="ativo_sim" class="adjacent">Sim</label>
    <input class="adjacent" type="radio" id="ativo_nao" name="ativo" value="0" <? if ($obj->id && $obj->ativo === 0) { ?>checked="checked"<? } ?> />
    <label for="ativo_nao" class="adjacent">N�o</label>

    <? include("../../include/inputs_email_senha.php"); ?>

    <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer_admin.php"); ?>