<?
include('include/header3.php');

if($atendenteSession || $gerenteSession) {
    $restaurante_id = $atendenteSession->restaurante_id ?: $gerenteSession->restaurante_id;
    $restaurante = Restaurante::find($restaurante_id);
    
    $novos = Pedido::all(array("order" => "quando", "conditions" => array("situacao = ? AND restaurante_id = ?", "novo_pedido", $restaurante_id)));
    $preparacao = Pedido::all(array("order" => "quando", "conditions" => array("situacao =? AND restaurante_id = ?", "pedido_preparacao", $restaurante_id)));
    $finalizados = Pedido::all(array("order" => "quando", "conditions" => array("( situacao=? OR situacao=? ) AND restaurante_id = ?", "pedido_concluido", "cancelado", $restaurante_id)));
} else {
    exit;
}
?>

<script type="text/javascript">
    function refreshPainel() {
	reloadPedidos
	var todos = $('.pedidos ul li');
	
	var novos = $('.pedidos#novos ul li'),
	    preparacao = $('.pedidos#preparacao ul li'),
	    finalizados = $('.pedidos#finalizados ul li');
	    
	var backgroundNovos = novos.css('background-color'),
	    backgroundPreparacao = preparacao.css('background-color'),
	    backgroundFinalizados = finalizados.css('background-color');
	    
	var corNovos = novos.css('color'),
	    corPreparacao = preparacao.css('color'),
	    corFinalizados = finalizados.css('color');
	
	todos.mouseover(function() {
	    $(this).css({'background-color': '#ccc', 'color': '#000'});
	});
	
	novos.mouseout(function() {
	    $(this).css({'background-color': backgroundNovos, 'color': corNovos});
	});
	
	preparacao.mouseout(function() {
	    $(this).css({'background-color': backgroundPreparacao, 'color': corPreparacao});
	});
	
	finalizados.mouseout(function() {
	    $(this).css({'background-color': backgroundFinalizados, 'color': corFinalizados});
	});
    }
    
    function reloadPedidos(situacao) {
	if(situacao == 'novo_pedido') target = $('#novos');
	if(situacao == 'pedido_preparacao') target = $('#preparacao');
	if(situacao == 'pedido_concluido' || situacao == 'cancelado') target = $('#finalizados');
	
	$.getJSON('php/controller/painel_pedidos_json', {'situacao': situacao}, function(data) {
	    if(!isEmpty(data)) {
		target.find('h3 span').html('(' + data.length + ')');
		
		$.each(data, function(index, key) {
		    target.find('ul').append(
			key.quandoFormatado + '<br />' +
			'<strong>' + key.consumidor.nome + '</strong>'
		    );
		});
	    }
	});
    }
    
    $(function() {
	refreshPainel();
	window.setInterval(refreshPainel, 5000);
    });
</script>

<h1 class="white_in_black center"><?= $restaurante->nome ?> - Painel de Pedidos</h1>

<?/*a href="javascript:void(0)" id="btn-atualizar">Atualizar</a >
<span id="loading-painel"><img src="<?= PATH_IMAGE_LOADING_15x15 ?>" alt="..." />Carregando...</span*/?>

<div id="colunas-pedidos">
    <div class="pedidos" id="novos">
	<h3>Pedidos novos <span>(<?= sizeof($novos) ?>)</span></h3>
	<ul>
	    <? if($novos) foreach($novos as $pedido) { ?>
	    <li>
		<?= $pedido->quando->format('d/m/Y - H:i') ?><br />
		<strong><?= $pedido->consumidor->nome ?></strong>
	    </li>
	    <? } ?>
	</ul>
    </div>

    <div class="pedidos" id="preparacao">
	<h3>Pedidos em preparo <span>(<?= sizeof($preparacao) ?>)</span></h3>
	<ul>
	    <? if($preparacao) foreach($preparacao as $pedido) { ?>
	    <li>
		<?= $pedido->quando->format('d/m/Y - H:i') ?><br />
		<strong><?= $pedido->consumidor->nome ?></strong>
	    </li>
	    <? } ?>
	</ul>
    </div>

    <div class="pedidos" id="finalizados">
	<h3>Pedidos finalizados <span>(<?= sizeof($finalizados) ?>)</span></h3>
	<ul>
	    <? if($finalizados) foreach($finalizados as $pedido) { ?>
	    <li>
		<?= $pedido->quando->format('d/m/Y - H:i') ?><br />
		<strong><?= $pedido->consumidor->nome ?></strong>
	    </li>
	    <? } ?>
	</ul>
    </div>
</div>

<div id="controles-pedido">
    <input id="btn-avancar" type="button" value="Avançar >>" />
    <input id="btn-cancelar" type="button" value="Cancelar pedido" />
</div>

<div id="detalhes-pedido">
    <div id="detalhes-cliente">
	<strong>#3232</strong><br /><br />
	<strong>Cliente:</strong> José da Silva Sauro<br /><br />
	<strong>Data e hora:</strong> 20/01/2012 - 19:00<br /><br />
	<strong>Endereço:</strong> Rua Joseph de Souza, 1281, Bairro Tal - Natal/RN<br /><br />
	<strong>Telefone(s):</strong> (84) 9999-0000 / (84) 1111-5555<br /><br />
    </div>
    <div id="detalhes-produtos">
    </div>
</div>

<? include('include/footer3.php'); ?>