<?
include('include/header.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("Consumidor");

$cidades = Cidade::all(array("order" => "nome asc"));
// $hash = 'consumidor' . time();

?>



<html>
<head><link rel="stylesheet" type="text/css" href="css/cadastro.css" >
<script type="text/javascript" src="jquery-1.6.4.min.js"></script>
<script type="text/javascript">



    var current_t = 1;

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
/*
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
		    addEnderecoConsumidor($('input, select, textarea', this).add('#hash').serializeArray(), 'enderecos');
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
	*/
	 function show(x){ 
        oque = document.getElementById(x);
        if(oque.style.display=='block'){
            oque.style.display = "none";
        }else{
            oque.style.display = "block";
        }
		
    }
</script>

</head>

<body>

<div id="login">
	<h1>Já sou cadastrado</h1>
    
    <form action="" method="post">
	
    <label class="normal12">E-mail:</label><br>
    <input type="text" name="email" value="" maxlength="100" />

	<label class="normal12">Senha:</label><br>
    <input type="password" name="senha" value="" maxlength="100" />
	
    <input class="btn" type="submit" value="OK"  />
    
   </form>
   
    <span>*Esqueci minha senha.</span>
  

</div><br>





<form action="php/controller/consumidor.php" method="post">
   <div id="etapa1" style="display:block;">
   
   <h1>Não tenho cadastro</h1>
   
    <label class="normal">Nome:</label><br>
    <input class="formfield w15" type="text" name="nome" value="" maxlength="100" /><br>

    <label class="normal">CPF:</label><br>
    <input class="formfield w15" type="text" name="cpf" value="" maxlength="100" /><br>

    <label class="normal">Data de Nascimento:</label><br>
    <input class="formfield w15" type="text" name="data_nascimento" value="" maxlength="100" /><br>

    <label class="normal">Sexo:</label><br>
    <label class="normal2">Masculino</label><input type="radio" name="sexo" value="masculino">  
    <label class="normal2">Feminino</label><input  type="radio" name= "sexo" value="feminino">
    
    <label class="normal">E-mail:</label><br>
    <input class="formfield w15" type="text" name="email" value="" maxlength="100" /><br>
    
    <label class="normal">Confirme email:</label><br>
    <input class="formfield w15" type="text" name="confirme_email" value="" maxlength="100" /><br>
    
	<label class="normal">Senha:</label><br>
    <input class="formfield w15" type="password" name="senha" value="" maxlength="100" /><br>
	
	<label class="normal">Confirme senha:</label><br>
    <input class="formfield w15" type="password" name="confirme_senha" value="" maxlength="100" /><br>


    <label class="normal">Telefones:</label><br>
    <div class="left w100" id="telInput">
	
    </div>
    
    <input class="btn" type="button" value="  +  " id="addPagina_t" /><br>
    
        
    <input class="btn" type="button" value="Prosseguir" onClick="show('etapa1');show('etapa2');" />
    
   
    </div>
    
    <div id="etapa2" style="display:none;" >
    <div id="form_endereco" title="Adicionar endereço">
	<label class="normal">Cidade:</label>
	
	<select class="w15 formfield" id="cidade_endereco" name="cidade_id">
	    <option value="">-- Selecione --</option>
	    <? if($cidades) foreach($cidades as $cidade) { ?>
	    <option value="<?= $cidade->id ?>"><?= $cidade->nome ?></option>
	    <? } ?>
	</select>
	
	<label class="normal">UF:</label><br>
	<input class="formfield w5" type="text" id="estado_endereco" name="estado" maxlength="2" style="text-transform:uppercase;" />
    
    <label class="normal">Bairro:</label><br>
	<select class="formfield w15" id="bairro_endereco" name="bairro_id"></select>
	
	<label class="normal">Endereço:</label><br>
	<input class="formfield w40" type="text" id="logradouro_endereco" name="logradouro" />
    
    <label class="normal">Complemento:</label><br>
	<input class="formfield w40" type="text" id="complemento_endereco" name="complemento" />
    
    <label class="normal">Número:</label><br>
	<input class="formfield w5" type="text" id="numero_endereco" name="numero" />
    
    <label class="normal">Ponto de referência:</label><br>
	<input class="formfield w40" type="text" id="referencia_endereco" name="referencia" />
	
    </div>
    
    <table class="list" id="enderecos">
	<tr>
    	<th>CEP</th>
    	<th>estado</th>
	    <th>Endereço</th>
        <th>complemento</th>
        <th>numero</th>
	    <th>Cidade</th>
	    <th>Bairro</th>
        <th>Referêcia</th>
	    <th>Favorito</th>
	    <th>Excluir</th>
	</tr>
	<? 
		if ($obj->enderecos) {
	    foreach($obj->enderecos as $endereco) {
			
	?>
	<tr>
    	 <td></td>
    	<td><?= $endereco->estado ?></td>
	    <td><?= $endereco->logradouro ?></td>
        <td><?= $endereco->complemento ?></td>
        <td><?= $endereco->numero ?></td>
	    <td><?= $endereco->bairro->cidade->nome ?></td>
	    <td><?= $endereco->bairro->nome ?></td>
        <td><?= $endereco->referencia ?></td>
        <td align="center"><input type="radio" name="favorito" <?= $endereco->favorito ? 'checked="true"' : '' ?> /></td>	
	    <td><a href="javascript:void(0)" class="excluir">Excluir</a></td>
	    
    </tr>
    
	<? } } else { ?>
	<tr id="nenhum_endereco"><td colspan="10" align="center">Nenhum endereço cadastrado</td></tr>
	<? } ?>
    </table>

   
    <input class="btn" type="submit" value="Concluir" />

</div>

</form>

</body>
</html>