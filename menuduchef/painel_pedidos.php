<?
include('include/header3.php');

if($atendenteSession || $gerenteSession) {
    $restaurante_id = $atendenteSession->restaurante_id ?: $gerenteSession->restaurante_id;
    $restaurante = Restaurante::find($restaurante_id);
    
    $novos = Pedido::all(array("order" => "quando", "conditions" => array("situacao = ? AND restaurante_id = ?", Pedido::$NOVO, $restaurante_id)));
    $preparacao = Pedido::all(array("order" => "quando", "conditions" => array("situacao =? AND restaurante_id = ?", Pedido::$PREPARACAO, $restaurante_id)));
    $finalizados = Pedido::all(array("order" => "quando", "conditions" => array("( situacao=? OR situacao=? ) AND restaurante_id = ?", Pedido::$CONCLUIDO, Pedido::$CANCELADO, $restaurante_id)));
} else {
    exit;
}
?>

<script type="text/javascript">
    var refreshPainel = function() {
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
	}).click(function () {
	    var pedido = $(this).data('pedido');
	    $('#btn-avancar, #btn-cancelar, #btn-retornar').data('pedido', pedido);
	    
	    $('#detalhes-cliente').empty().append($(
		'<strong>#' + pedido.id + '</strong><br /><br />' +
		'<strong>Cliente:</strong> ' + pedido.consumidor.usuario.nome + '<br /><br />' +
		'<strong>Data e hora:</strong> ' + pedido.quandoFormatado + '<br /><br />' +
		'<strong>Endereço:</strong> ' + pedido.endereco_consumidor.__toString + '<br /><br />' +
		'<strong>Telefone(s):</strong> ' + pedido.consumidor.getTelefonesFormatado + '<br /><br />'
	    ));
		
	    if(pedido.pedido_tem_produtos) {
		var table = $('<table>');
		table.append($('<tr><th width="10%">Qtd.</th><th width="70%">Produto</th><th width="20%">Preço</th></tr>'));
		
		$.each(pedido.pedido_tem_produtos, function(index, key) {
		    table.append($('<tr><td>' + key.qtd + '</td><td>' + key.produto.nome + '</td><td>' + (key.getTotalFormatado) + '</td></tr>'));
		});
		
		table.append($('<tr><th colspan="3">Total: ' + pedido.getTotalFormatado + '</th></tr>'));
		
		$('#detalhes-produtos').empty().append(table);
	    }
	});
	
	novos.mouseout(function() {
	    $(this).css({'background-color': backgroundNovos, 'color': corNovos});
	});
	
	preparacao.mouseout(function() {
	    $(this).css({'background-color': backgroundPreparacao, 'color': corPreparacao});
	});
	
	finalizados.mouseout(function() {
	    backgroundFinalizados = $(this).data('pedido').situacao == '<?= Pedido::$CONCLUIDO ?>' ? 'blue' : 'red';
	    $(this).css({'background-color': backgroundFinalizados, 'color': corFinalizados});
	});
    }
    
    var reloadPedidos = function() {
	$.getJSON('php/controller/painel_pedidos_json', function(data) {
	    if(!isEmpty(data)) {
		var qtdNovos = 0, qtdPreparacao = 0, qtdFinalizados = 0;
		
		$('#novos ul').empty();
		$('#preparacao ul').empty();
		$('#finalizados ul').empty();
		
		$.each(data, function(index, key) {
		    var target, backgroundFinalizado;
		    
		    if(key.situacao == '<?= Pedido::$NOVO ?>') {
			target = $('#novos');
			qtdNovos++;
		    }
		    
		    if(key.situacao == '<?= Pedido::$PREPARACAO ?>') {
			target = $('#preparacao');
			qtdPreparacao++;
		    }
		    
		    if(key.situacao == '<?= Pedido::$CONCLUIDO ?>' || key.situacao == '<?= Pedido::$CANCELADO ?>') {
			if(key.situacao == '<?= Pedido::$CONCLUIDO ?>') {
			    backgroundFinalizado = 'blue';
			}
			
			if(key.situacao == '<?= Pedido::$CANCELADO ?>') {
			    backgroundFinalizado = 'red';
			}
			
			target = $('#finalizados');
			qtdFinalizados++;
		    }
		    
		    if(target) {
			var elementPedido = $(
			    '<li>' +
				'<strong>#' + key.id + '</strong> ' +
				key.quandoFormatado + '<br />' +
				'<strong>' + key.consumidor.usuario.nome + '</strong>' +
			    '</li>'
			).data('pedido', key);
			
			if(backgroundFinalizado) {
			    elementPedido.css('background-color', backgroundFinalizado);
			}
			
			target.find('ul').append(elementPedido);
		    }
		});
		
		$('#novos h3 span').html('(' + qtdNovos + ')');
		$('#preparacao h3 span').html('(' + qtdPreparacao + ')');
		$('#finalizados h3 span').html('(' + qtdFinalizados + ')');
	    }
	    
	    refreshPainel();
	});
    }
    
    $(function() {
	reloadPedidos();
	window.setInterval(reloadPedidos, 5000);
	
	$('#btn-avancar, #btn-cancelar, #btn-retornar').click(function() {
	    var pedido = $(this).data('pedido');
	    
	    if(pedido) {
		var isAvancar = $(this).attr('id') == 'btn-avancar',
		    isRetornar = $(this).attr('id') == 'btn-retornar',
		    isCancelar = $(this).attr('id') == 'btn-cancelar',
		    op = null;
		    
		if(isAvancar) op = 'avancar';
		if(isRetornar) op = 'retornar';
		if(isCancelar) op = 'cancelar';
		
		if(op == 'cancelar') {
		    if(!window.confirm('Cancelar o pedido #' + pedido.id + '?')) {
			return;
		    }
		}

		$.ajax('php/controller/painel_pedidos_salvar', {
		    data: {'id': pedido.id, 'op': op},
		    success: reloadPedidos
		});
	    } else {
		alert('Nenhum pedido para ' + (isAvancar ? 'avançar' : 'cancelar'));
	    }
	});
    });
</script>

<h1 class="white_in_black center"><?= $restaurante->nome ?> - Painel de Pedidos</h1>

<?/*a href="javascript:void(0)" id="btn-atualizar">Atualizar</a >
<span id="loading-painel"><img src="<?= PATH_IMAGE_LOADING_15x15 ?>" alt="..." />Carregando...</span*/?>

<div id="colunas-pedidos">
    <div class="pedidos" id="novos">
	<h3>Pedidos novos <span></span></h3>
	<ul></ul>
    </div>

    <div class="pedidos" id="preparacao">
	<h3>Pedidos em preparo <span></span></h3>
	<ul></ul>
    </div>

    <div class="pedidos" id="finalizados">
	<h3>Pedidos finalizados <span></span></h3>
	<ul></ul>
    </div>
</div>

<div id="controles-pedido">
    <input id="btn-retornar" type="button" value="<< Retornar" />
    <input id="btn-avancar" type="button" value="Avançar >>" />
    <input id="btn-cancelar" type="button" value="Cancelar pedido" />
</div>

<div id="detalhes-pedido">
    <div id="detalhes-cliente"></div>
    <div id="detalhes-produtos"></div>
</div>

<? include('include/footer3.php'); ?>