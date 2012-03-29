<?
ob_start();

include('include/header3.php');
include("include/session_vars.php");

if ($consumidorSession) {

$obj = $consumidorSession;

$cidades = Cidade::all(array("order" => "nome asc"));
$now = time();
$hash_consumidor = 'consumidor' . $now;
$hash_consumidor2 = 'consumidor' . ($now + 1);

$enderecosJson = StringUtil::arrayActiveRecordToJson($obj->enderecos, array('methods' => array('hash', '__toString'), 'include' => array('bairro' => array('include' => 'cidade'))));
$_SESSION[$hash_consumidor] = json_decode($enderecosJson, true);

$telefonesJson = StringUtil::arrayActiveRecordToJson($obj->telefones, array('methods' => array('hash', '__toString')));
$_SESSION[$hash_consumidor2] = json_decode($telefonesJson, true);

?>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/util.js"></script>
<script type='text/javascript' src="js/quickmenu.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/menu.css" />
<link rel="stylesheet" type="text/css" href="css/custom-theme/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript">

    function show(x){
        oque = document.getElementById(x);
        if(oque.style.display=='block'){
            oque.style.display = "none";
        }else{
            oque.style.display = "block";
        }
    }

    $(function() {

        listEnderecosConsumidor(<?= $enderecosJson ?>, 'enderecos', '<?= $hash_consumidor ?>');
        listTelefonesConsumidor(<?= $telefonesJson ?>, 'telefones', '<?= $hash_consumidor2 ?>');
        
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
<div>
    <input type="button" onclick="show('dados_cadastrais')" value="Alterar Dados Cadastrais">
</div>

<div id="dados_cadastrais" style="display:none;">
<form action="php/controller/consumidor_auto_cadastro" method="post">


    <a id="add_endereco" class="left w100 bottom10" href="javascript:void(0)">Adicionar</a>
    <br /><br />
    <div id="form_endereco" title="Adicionar endereço">
        <div id="mensagens_endereco"></div>

        <input type="hidden" id="endereco_id" name="endereco_id" value="" />
        <input type="hidden" name="hash" value="" />

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

        <label for="numero_endereco" class="normal">Número:</label>
        <input class="formfield w15" type="text" id="numero_endereco" name="numero" />

        <label for="complemento_endereco" class="normal">Complemento:</label>
        <input class="formfield w25" type="text" id="complemento_endereco" name="complemento" />

        <label for="cep_endereco" class="normal">CEP:</label>
        <input class="formfield w25" type="text" id="cep_endereco" name="cep" />

        <input class="adjacent clear-left top10" type="checkbox" id="checkbox_endereco_favorito" name="favorito" value="1" />
        <label class="adjacent top10" for="checkbox_endereco_favorito">Atribuir como endereço favorito</label>
    </div>




    <div style="margin-top:50px;">
          <input style="position:relative; float: left;"  type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" /> 
          <input style="position:relative; float: left;"  type="button" onclick="location.href=('area_usuario')" value="Cancelar">
    </div>
</form>
</div>
<?
}
else{
    header("location:index");
}
?>