<?
    $admin = unserialize($_SESSION['usuario_obj']);
?>
<script>
    function abre_atendimento(){
        
        var width = 1000;
        var height = 600;
        var left = (screen.width - width) / 2;
        var top = ((screen.height - height) / 2) - 30;
        
        var w = window.open('atendimento/atendente/index.php', 'at',  'height=' +height+ ', width=' +width+ ',status=no, toolbar=no, resizable=no, scrollbars=no, minimizable=no, left=' +left+ ', top=' +top);
    }
</script>    
<h1 class="white_in_black center"><?= SITE_TITLE ?> - Área Administrativa</h1>
<div id="painel_area_administrativa">
    <div id="qm0" class="qmmc">
        <a href="javascript:void(0)">ADMINISTRAÇÃO</a>
        <div>
            <a href="admin/administrador/">Administradores</a>
            <!--<a href="admin/cidade/">Cidades</a>-->
            <!--<a href="admin/bairro/">Bairros</a>-->
            <a href="admin/consumidor/">Clientes</a>
            <a href="admin/forma_pagamento/">Formas de Pagamento</a>
            <? if($admin->email=="paulo@agenciabiro.com.br"||$admin->email=="cesar@agenciabiro.com.br"||$admin->email=="rodolfo@agenciabiro.com.br"){ ?>
            <a href="admin/cupom/">Cupons</a>
            <a href="admin/lote_cupom/">Lotes de Cupons</a>
            <? } ?>
        </div>
        <span class="qmdivider qmdividery"></span>
        <a href="javascript:void(0)">RESTAURANTES</a>
        <div>
            <a href="admin/restaurante/">Restaurantes</a>
            <a href="admin/usuario_restaurante/">Gerentes e Atendentes de Restaurantes</a>
            <a href="admin/tipo_restaurante/">Tipos de Restaurante</a>
        </div>
        <span class="qmdivider qmdividery"></span>
        <a href="javascript:void(0)">PRODUTOS</a>
        <div>
            <a href="admin/produto/">Produtos</a>
            <a href="admin/produto_adicional/">Produtos Adicionais</a>
            <a href="admin/tipo_produto/">Tipos de Produto</a>
        </div>
        <span class="qmdivider qmdividery"></span>
        <a href="javascript:void(0)">PEDIDOS</a>
        <div>
            <a href="admin/pedido/">Pedidos</a>
            <!--<a href="admin/pedido_tem_produto/">Produtos inclusos em Pedidos</a>
            <a href="admin/pedido_tem_produto_adicional/">Produtos Adicionais inclusos em Pedidos</a>-->
        </div>
        <span class="qmdivider qmdividery"></span>
        <a href="javascript:void(0)">Atendimento Online</a>
        <div>
            <a href="javascript:void(0)" onclick="abre_atendimento()">Atendimento Online</a>
        </div>
        <span class="qmclear"> </span>
    </div>
    <script type="text/javascript">qm_create(0,false,0,250,false,false,false,false,false);</script>
    <div class="right tright w50">
        <? if($usuario_logado) { ?>
	    <strong><?= $usuario_logado->nome ?></strong>
	    - <?= $usuario_logado->getNomePerfil() ?>
	    <? if($usuario_logado->tipo == Usuario::$GERENTE || $usuario_logado->tipo == Usuario::$ATENDENTE) { ?>- <?= $usuario_logado_obj->restaurante->nome ?><? } ?>
	    |
	<? } ?>
	<a href="php/controller/logout" title="Sair">Sair</a>
    </div>
</div>