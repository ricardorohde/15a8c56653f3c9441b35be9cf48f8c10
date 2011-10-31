<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("Consumidor");

$cidades = Cidade::all(array("order" => "nome asc"));
?>

<script type="text/javascript">
    $(function() {
        $cid = 0;
        
        <?
        if($obj->enderecos) {
            foreach($obj->enderecos as $ende){    
                if($ende->favorito){
                    $cid = $ende->bairro->cidade_id;
                    echo "<alert>".$ende->bairro_id."</alert>";
                    echo "<alert>".$cid."</alert>";
                }
            }
        }
        ?>
	autoCompleteBairros(<?= $cid ?: 0 ?>, <?= 0 ?: 0 ?>); //$obj->bairro_id
	    
	$('#cidades').change(function() {
	    autoCompleteBairros($(this).val());
	});
    });
</script>

<script type="text/javascript">
	    var current_t = <?= $obj->telefones ? (sizeof($obj->telefones) + 1) : 1 ?>;
	
	    function addInput_t(suffix) {
		$('#telInput').append($(
		'<div id="input' + suffix + '">'
		    + '   <input name="telefone' + suffix + '" type="text" size="20" />'
		    + (suffix > 1 ? ' <span onclick="this.parentNode.parentNode.removeChild(this.parentNode)">X</span>' : '')
		    + '</div>'
	    ));
	    }
	
	    $(function() {
		addInput_t(current_t);
		$('#addPagina_t').click(function() {
		    addInput_t(++current_t);
		});
	    });
	</script>

<script type="text/javascript">
	  var current_e = <?= $obj->enderecos ? (sizeof($obj->enderecos) + 1) : 1 ?>;
	
	    function addInput_e(suffix) {
		$('#endInput').append($(
		'<div id="input' + suffix + '">'
		    + '   <select name="cidade' + suffix + '" type="text"  ></select>'
                    + '   <select name="bairro' + suffix + '" type="text"  ></select>'
                    + '   <input name="logradouro' + suffix + '" type="text" size="20" />'
		    + (suffix > 1 ? ' <span onclick="this.parentNode.parentNode.removeChild(this.parentNode)">X</span>' : '')
		    + '</div>'
	    ));
	    }
	
	    $(function() {
		addInput_e(current_e);
		$('#addPagina_e').click(function() {
		    addInput_e(++current_e);
		});
	    });
	</script>

<h2><a href="admin/">Menu Principal</a> &raquo; Gerenciar Clientes</h2>

<a href="admin/consumidor/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/consumidor/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />

    Nome<br />
    <input type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br /><br />
    
    CPF<br />
    <input type="text" name="cpf" value="<?= $obj->cpf ?>" maxlength="100" /><br /><br />
    
    Data de Nascimento<br />
    <input type="text" name="data_nascimento" value="<?= $obj->data_nascimento ?>" maxlength="100" /><br /><br />
    
    Sexo<br />
    <input type="text" name="sexo" value="<?= $obj->sexo ?>" maxlength="100" /><br /><br />
    
    Telefone<div id="telInput">
    <?
    if($obj->telefones){
        $telc = 1;
        foreach($obj->telefones as $tel){ ?>
            <div><input type="text" name="telefone<?= $telc ?>" value="<?= $tel->numero ?>" maxlength="100" /><span onclick="this.parentNode.parentNode.removeChild(this.parentNode)">X</span></div>
        <? $telc++; }
    }?>
    </div>
    <input type="button" value="  +  " title="Adicionar mais páginas" id="addPagina_t" /><br /><br />
    
    
    Cidade<br />
    <select id="cidades" name="cidade_id">
	<option value="">-- Selecione --</option>
	<?
	if($cidades) {
            $favorito = 0;
            foreach($obj->enderecos as $ende){
                if($ende->favorito){
                    $favorito = $ende->bairro_id;
                }
            }
	    foreach($cidades as $cidade) {
	?>
	<option value="<?= $cidade->id ?>" <? if($cidade->id == $favorito) { ?>selected="true"<? } ?>><?= $cidade->nome ?></option>
	<? } } ?>
    </select>
    <br /><br />
  
    Bairro<br />
    <select id="bairros" name="bairro_id"></select>
    <br /><br />
         
    Endere&ccedil;o<div id="endInput">
    <?
    if($obj->enderecos){
        $endc = 1;
        foreach($obj->enderecos as $ende){ ?>
            <div><input type="text" name="endereco<?= $telc ?>" value="<?= $ende->logradouro ?>" maxlength="100" /><span onclick="this.parentNode.parentNode.removeChild(this.parentNode)">X</span></div>
        <? $endc++; }
    }?>
    </div>
    <input type="button" value="  +  " title="Adicionar mais páginas" id="addPagina_e" /><br /><br /> 
    
    Ativo<br />
    <input type="radio" name="ativo" value="1" <? if (!$obj->id || $obj->ativo === 1) { ?>checked="true"<? } ?> />Sim
    <input type="radio" name="ativo" value="0" <? if ($obj->id && $obj->ativo === 0) { ?>checked="true"<? } ?> />Não
    <br /><br />
 
    <? include("../../include/inputs_email_senha.php"); ?>
    
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>