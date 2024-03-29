<?
include("include/header.php");

$data = HttpUtil::getParameterArray();

$page = $data['page'] ? : 1;
if($_POST){
    unset($_SESSION['categorias']);
    $_SESSION['categorias'] = $data['categorias'];
}
$categoriasFiltro = $_SESSION['categorias'];
unset($_SESSION['pedido_id']); //variavel criada por Paulo

if(($_POST['end_id'])&&($_SESSION['usuario'])){ //essa variavel "end_id" guarda o id do ENDERECO e do BAIRRO, separados por um _
    $end = explode("_",$_POST['end_id']);
    $conditions = 'rab.bairro_id = ' . ((int)$end[1]);
    
    $dados_end = EnderecoConsumidor::find($end[0]);
    $_SESSION['endereco'] = serialize($dados_end);
}else{
    $conditions = 'rab.bairro_id = ' . $enderecoSession->bairro_id;
}
$conditions .= ' and restaurante.ativo = 1 ';
if($_POST['caixa_filtro']){
    $conditions .= ' and restaurante.nome like "%' . $_POST['caixa_filtro'] . '%" ';
    
}

if($categoriasFiltro) {
    $categoriasToConditions = implode(',', $categoriasFiltro);
    
    $conditions .= ' 
	and exists(
	    select 1 from restaurante_tem_tipo rtt
	    where
		rtt.restaurante_id = restaurante.id
		and rtt.tiporestaurante_id in (' . $categoriasToConditions . ')
	)
    ';
        
}


if ($enderecoSession) {
    $paginacao = new Paginacao('Restaurante', array(
	    'joins' => 'inner join restaurante_atende_bairro rab on rab.restaurante_id = restaurante.id',
	    'conditions' => $conditions,
	    'order' => 'ordem asc'
	    ), 'restaurantes', $page, 6, 5, '?page=');

    $restaurantes = $paginacao->list;

    if($_POST['end_id']){
        $end = explode("_",$_POST['end_id']);
        $categorias = TipoRestaurante::find_and_count_by_bairro_id($end[1]);
        $end_id = $end[0]."_".$end[1];
    }else{
        $categorias = TipoRestaurante::find_and_count_by_bairro_id($enderecoSession->bairro_id);
        $end_id = $enderecoSession->id."_".$enderecoSession->bairro_id;
    }
}
?>
<script>
    $(function() {
        $("#filtrar").click(function(){
            $("#page").attr("value",1);
            $("form").submit();
        });
        $(".filtro_categoria").click(function(){
            $("#page").attr("value",1);
            $("form").submit();
        });
        $("#endereco_cliente").change(function(){
            $("#end_id").attr("value",$(this).attr("value"));
            $("#page").attr("value",1);
            $("form").submit();
        });
    });
</script>
<?php if($_SESSION['usuario']){
        include "menu_user.php";
    }else{
        include "menu2.php"; 
    } ?>
<form action="restaurantes" method="post">
<div id="central" class="span-24">
    <div class="span-6">
	<div id="barra_esquerda">   
	    <div id="seleciona_endereco">
		<img src="background/titulo_endereco.gif" width="114" height="30" alt="Endereço" style="margin-left:12px">
		<div style="width:198px; height:25px; margin-left:7px;">
                    <select id="endereco_cliente" name="endereco_cliente" style="width:195px; margin-left:3px; border:1px solid #bcbec0;">
		    <? if ($enderecoSession->consumidor) { 
                            foreach($enderecoSession->consumidor->enderecos as $end){
                                $sel = "";
                                if($_POST['end_id']){
                                    $e = explode("_",$_POST['end_id']);
                                    if($e[0]==$end->id){
                                        $sel="selected";
                                    }
                                }
                    ?>
                            <option value="<?= $end->id ?>_<?= $end->bairro_id ?>" <?= $sel ?>><?= $end->logradouro ?>, <?= $end->numero ?> - <?= $end->bairro ?> | <?= $end->bairro->cidade ?></option>
		    <? }
                    }else{ ?>
                        <option value="<?= $enderecoSession->id ?>_<?= $enderecoSession->bairro_id ?>"><?= $enderecoSession->logradouro ?> - <?= $enderecoSession->bairro ?> | <?= $enderecoSession->bairro->cidade ?></option>
                    <? }
                    ?>
    		    </select>
		    
		</div>
	    </div>
            <input type="hidden" name="end_id" id="end_id" value="<?= $end_id ?>">    
	    <br clear="all" /><br clear="all" />
	    
		<? if($paginacao) { ?><input type="hidden" id="page" name="page" value="<?= $paginacao->page ?>" /><? } ?>
		<div id="busca">
		    <img src="background/titulo_busca.gif" width="71" height="26" alt="Busca" style="margin-left:12px">
		    <div style="width:198px; height:25px;  margin-left:10px;">
			<input id="caixa_filtro" name="caixa_filtro" type="text" style="float:left; margin: auto 0; width:140px; position:relative;" value="<?= $_POST['caixa_filtro'] ?>"> 
			<img class="refino" id="filtrar" src="background/botao_ok.gif" style="float:right; border:0; width:40px; height:24px; position:relative; cursor:pointer;">                   	    	
		    </div>
		</div>
		<div id="filtro">
		    <img src="background/titulo_filtro.gif" width="74" height="26" alt="Filtro" style="margin-left:12px">
		    <div style="padding-top:5px;">
			<div style="color:#CC0000; padding-top:5px; padding-left:12px;">
			    <?
			    if($categorias) {
				foreach($categorias as $categoria) {
				    $checked = $categoriasFiltro && in_array($categoria->id, $categoriasFiltro);
			    ?>
			    <div style="color:#CC0000; padding-top:5px; padding-left:0px;">
				<input type="checkbox" class="refino filtro_categoria" id="checkrest_<?= $categoria->id ?>" name="categorias[]" value="<?= $categoria->id ?>" <?= $checked ? 'checked="checked"' : '' ?> /> &nbsp;<?= $categoria->nome ?> (<?= $categoria->count ?>)
			    </div>
			    <? } } ?>
			</div>
		    </div>
		</div>
	    
	</div>
    </div>
    <div class="span-18 last">
	<div style="height: 1050px">
	    <div class="prepend-top" id="status">
		<div id="numero_rest"><span style="margin-left:8px;"> </span></div> 
		<div id="status_pedido">
		    <img src="background/passo.png" width="541" height="43" alt="passo1">
		</div>
	    </div>

	    <div id="caixa_sup">
		<h1 id="rest_titulo">Restaurantes</h1>
		<? if ($paginacao && $paginacao->getHtml()) { ?>
		<div id="contagem_pag">
			<?= $paginacao->getHtml() ?>
		</div>
		<? } ?>
	    </div>

	    <?
	    if ($restaurantes) {
		foreach ($restaurantes as $restaurante) {
		    ?>

		    <? include 'box_restaurante.php' ?>

		<? }
	    } else { ?>
	    <br /><br />
	    <p>Nenhum restaurante encontrado na sua localidade</p>
	    <? } ?>

	    <? if ($paginacao && $paginacao->getHtml()) { ?>
	    <div class="radios prepend-top" id="caixa_sup">
		<div id="contagem_pag">
			<?= $paginacao->getHtml() ?>
		</div>
	    </div>
	    <? } ?>
	</div>
	<div id="rodape" class="prepend-top">
	    <img src="background/rodape.jpg" width="760" height="69" style="margin-left:-61px;">
	</div>
    </div>
</div>
</form>    
<? include('include/footer.php'); ?>