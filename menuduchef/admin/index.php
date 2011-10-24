<? require("../php/lib/config.php"); ?>
<html>
    <head>
	<title><?= SITE_TITLE ?></title>
	<style>
	ul li span.title { font-weight: bold; }
	</style>
    </head>
    <body>
	<h1>�rea Administrativa</h1>
	<ul>
	    <li>
		<span class="title">Cadastros B&aacute;sicos</span>
		<ul>
		    <li>
			<a href="administrador/" title="Administradores">Administradores</a>
		    </li>
		    <li>
			<a href="cidade/" title="Cidades">Cidades</a>
		    </li>
		    <li>
			<a href="bairro/" title="Bairros">Bairros</a>
		    </li>
		    <li>
			<a href="consumidor/" title="Consumidores">Consumidores</a>
		    </li>
		</ul>
	    </li>
	    <li>
		<span class="title">Restaurantes</span>
		<ul>
		    <li>
			<a href="tipo_restaurante/" title="Tipos de Restaurante">Tipos de Restaurante</a>
		    </li>
		    <li>
			<a href="restaurante/" title="Restaurantes">Restaurantes</a>
		    </li>
		    <li>
			<a href="usuario_restaurante/" title="Usu&aacute;rios de Restaurante">Usu&aacute;rios de Restaurante</a>
		    </li>
		    <li>
			<a href="restaurante_tem_tipo/" title="Restaurantes tem Tipo">Restaurantes tem Tipo</a>
		    </li>
		    <li>
			<a href="restaurante_tem_tipo_produto/" title="Restaurantes tem Tipo Produto">Restaurantes tem Tipo Produto</a>
		    </li>
		    <li>
			<a href="restaurante_atende_bairro/" title="Restaurantes Atendem Bairros">Restaurantes Atendem Bairros</a>
		    </li>
		</ul>
	    </li>
	    <li>
		<span class="title">Produtos</span>
		<ul>
		    <li>
			<a href="tipo_produto/" title="Tipos de Produto">Tipos de Produto</a>
		    </li>
		    <li>
			<a href="produto/" title="Produtos">Produtos</a>
		    </li>
		    <?/*li>
			<a href="produto_tem_tipo/" title="Produtos tem Tipo">Produtos tem Tipo</a>
		    </li*/?>
		    <li>
			<a href="produto_adicional/" title="Produtos Adicionais">Produtos Adicionais</a>
		    </li>
		    <?/*li>
			<a href="produto_tem_produto_adicional/" title="Produtos Adicionais pertencentes a Produtos">Produtos Adicionais pertencentes a Produtos</a>
		    </li*/?>
		</ul>
	    </li>
	    <li>
		<span class="title">Pedidos</span>
		<ul>
		    <li>
			<a href="pedido/" title="Pedidos">Pedidos</a>
		    </li>
		    <li>
			<a href="pedido_tem_produto/" title="Produtos inclusos em Pedidos">Produtos inclusos em Pedidos</a>
		    </li>
		    <li>
			<a href="pedido_tem_produto_adicional/" title="Produtos Adicionais inclusos em Pedidos">Produtos Adicionais inclusos em Pedidos</a>
		    </li>
		</ul>
	    </li>
	</ul>
    </body>
</html>