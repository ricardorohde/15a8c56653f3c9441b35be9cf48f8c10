<?
require("php/lib/config.php");

$cidades = Cidade::all();

?>

<html>
	<head>
		<title>Menu du Chef</title>
		<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
		<script type="text/javascript">
			$(function() {
				$('.cidade').click(function() {
					var linhaCidade = $(this);
					var idCidade = linhaCidade.attr('href').replace('#cidade', '');

					$.getJSON('php/controller/list_bairros.php', {'id': idCidade}, function(data) {
						if(data.length) {
							$('ul', linhaCidade).remove();
							linhaCidade.append($('<ul/>'));

							$.each(data, function(key, value) {
								$('ul', linhaCidade).append($('<li>' + value + '</li>'));
							});
						}
					});

					return false;
				});
			});
		</script>
	</head>
	<body>
		<ul>
			<?
			if($cidades) {
				foreach($cidades as $cidade) {
			?>

			<li><a href="#cidade<?= $cidade->id ?>" class="cidade"><?= $cidade->nome ?></a></li>

			<?
				}
			} else {
			?>

			<li>Nenhuma cidade cadastrada</li>

			<? } ?>
		</ul>
	</body>
</html>