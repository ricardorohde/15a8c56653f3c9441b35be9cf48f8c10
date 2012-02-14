<?
include("include/header.php");

$data = HttpUtil::getParameterArray();

$page = $data['page'] ? : 1;
$categoriasFiltro = $data['categorias'];

$conditions = 'rab.bairro_id = ' . $enderecoSession->bairro_id;

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
	    'order' => 'nome asc'
	    ), 'restaurantes', $page, 6, 5);

    $restaurantes = $paginacao->list;
    
    $categorias = TipoRestaurante::find_and_count_by_bairro_id($enderecoSession->bairro_id);
}
?>

<?php include "menu2.php" ?>

<div id="central" class="span-24">
    <div class="span-6">
	<div id="barra_esquerda">
	    <div id="seleciona_endereco">
		<img src="background/titulo_endereco.gif" width="114" height="30" alt="Endereço" style="margin-left:12px">
		<div style="width:198px; height:25px; margin-left:7px;">
		    <? if ($enderecoCepSession) { ?>
			<?= $enderecoSession->logradouro ?><br />
			CEP: <?= StringUtil::formataCep($enderecoSession->cep) ?><br />
			<?= $enderecoSession->bairro ?> - <?= $enderecoSession->bairro->cidade ?>
		    <? } else { ?>
    		    <select id="endereco_cliente" name="endereco_cliente" style="width:195px; margin-left:3px;">
			    <? if($enderecoSession){
                                foreach($enderecoSession as $es){ ?>
                                    <option value="<?= $es->bairro_id ?>"><?= $es->bairro->nome ?></option>
                            <? }
                            }?>
    		    </select>
		    <? } ?>
		</div>
	    </div>
	    <br clear="all" /><br clear="all" />
	    <form method="post">
		<? if($paginacao) { ?><input type="hidden" name="page" value="<?= $paginacao->page ?>" /><? } ?>
		<div id="busca">
		    <img src="background/titulo_busca.gif" width="71" height="26" alt="Busca" style="margin-left:12px">
		    <div style="width:198px; height:25px;  margin-left:10px;">
			<input id="caixa_filtro" name="caixa_filtro" type="text" style="float:left; margin: auto 0; width:140px; position:relative;"> 
			<input type="image" class="refino" value="submit" id="filtrar" src="background/botao_ok.gif" style="float:right; margin-top:-4px; border:0; width:40px; height:24px; position:relative; cursor:pointer;">                   	    	
		    </div>
		</div>
		<div id="filtro">
		    <img src="background/titulo_filtro.gif" width="74" height="26" alt="Filtro" style="margin-left:12px">
		    <div style="padding-top:5px;">
			<div style="color:#CC0000; padding-top:5px; padding-left:12px;">
			    <?
			    if($categorias) {
				foreach($categorias as $categoria) {
				    $checked = !$categoriasFiltro || in_array($categoria->id, $categoriasFiltro);
			    ?>
			    <div style="color:#CC0000; padding-top:5px; padding-left:12px;">
				<input type="checkbox" class="refino filtro_categoria" id="checkrest_<?= $categoria->id ?>" name="categorias[]" value="<?= $categoria->id ?>" <?= $checked ? 'checked="checked"' : '' ?> /> &nbsp; <?= $categoria->nome ?> (<?= $categoria->count ?>)
			    </div>
			    <? } } ?>
			</div>
		    </div>
		</div>
	    </form>
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
<? include('include/footer.php'); ?>