<h1 class="white_in_black center"><?= SITE_TITLE ?> - Área Administrativa</h1>
<div id="painel_area_administrativa">
    <div id="qm0" class="qmmc">
        <a href="javascript:void(0)">ADMINISTRAÇÃO</a>
        <div>
            <a href="admin/administrador/">Administradores</a><br/>
            <a href="admin/cidade/">Cidades</a><br/>
            <a href="admin/bairro/">Bairros</a><br/>
            <a href="admin/consumidor/">Consumidores</a><br/><br/>
        </div>
        <span class="qmdivider qmdividery"></span>
        <a href="javascript:void(0)">RESTAURANTES</a>
        <div>
            <a href="admin/tipo_restaurante/">Tipos de Restaurante</a><br/>
            <a href="admin/restaurante/">Restaurantes</a><br/>
            <a href="admin/usuario_restaurante/">Gerentes e Atendentes de Restaurantes</a><br/>
            <a href="admin/restaurante_tem_tipo/">Restaurantes tem Tipos</a><br/>
            <a href="admin/restaurante_tem_tipo_produto/">Restaurantes tem Tipos de Produto</a><br/>
            <a href="admin/restaurante_atende_bairro/">Restaurantes Atendem Bairros</a><br/><br/>
        </div>
        <span class="qmdivider qmdividery"></span>
        <a href="javascript:void(0)">PRODUTOS</a>
        <div>
            <a href="admin/tipo_produto/">Tipos de Produto</a><br/>
            <a href="admin/produto/">Produtos</a><br/>
            <a href="admin/produto_adicional/">Produtos Adicionais</a><br/><br/>
        </div>
        <span class="qmdivider qmdividery"></span>
        <a href="javascript:void(0)">PEDIDOS</a>
        <div>
            <a href="admin/pedido/">Pedidos</a><br/><br/>
            <!--<a href="admin/pedido_tem_produto/">Produtos inclusos em Pedidos</a>
            <a href="admin/pedido_tem_produto_adicional/">Produtos Adicionais inclusos em Pedidos</a>-->
        </div>
        <span class="qmclear"> </span>
    </div>
    <script type="text/javascript">qm_create(0,false,0,250,false,false,false,false,false);</script>
    <div class="right tright w50">
        <strong>Manolo da Silva Sauro</strong> - Gerente - Restaurante do Biro | <a href="admin/sair" title="Sair">Sair</a>
    </div>
</div>
<? include("messages.php"); ?>