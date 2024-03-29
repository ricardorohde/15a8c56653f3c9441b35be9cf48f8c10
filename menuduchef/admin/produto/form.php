<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("Produto");

$restaurantes = Restaurante::all(array("order" => "nome asc"));
$tipos = TipoProduto::all(array("order" => "nome asc"));
?>

<script type="text/javascript">
    $(function() {
        <? if($obj->id){ ?>
            autoCompleteProdutosAdicionaisCheckBox(<?= $obj->restaurante_id ?>, <?= $obj->id ?>);          
        <? } ?>
	
	$('#restaurantes').change(function() {
	    autoCompleteProdutosAdicionaisCheckBox($(this).val());
	});
    });
</script>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Produtos</h2>

<a href="admin/produto/" title="Cancelar">Cancelar</a>

<form action="admin/produto/controller" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    <input type="hidden" name="edita_tipos" value="1" />
    <input type="hidden" name="edita_produtos_adicionais" value="1" />
    
    <label class="normal">Restaurante:</label>
    <? if($obj->restaurante_id){ ?>
	<label class="adjacent"><?= $obj->restaurante->nome ?></label>
    <? } else { ?>
    <select class="formfield w40" name="restaurante_id" id="restaurantes">
	<option value="">-- Selecione --</option>
	<?
	if ($restaurantes) {
	    foreach ($restaurantes as $restaurante) {
		?>
		<option value="<?= $restaurante->id ?>" <? if ($restaurante->id == $obj->restaurante_id) { ?>selected="selected"<? } ?>><?= $restaurante->nome ?></option>
	    <? }
	} ?>
    </select>
    <? } ?>
    
    <label class="normal">Nome do produto:</label>
    <input class="formfield w50" type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" />
    
    <label class="normal">Foto:</label>
    <input class="formfield w50" type="file" name="imagem" maxlength="100" />
    <? if($obj->imagem) { ?>
    <br clear="all" /><img src="<?= $obj->getUrlImagem() ?>" class="left" alt="<?= $obj->nome ?>" />
    <!--<a href="php/controller/exclude_image" class="left bold red" onclick="return confirm('Excluir imagem?')">X</a>-->
    <? } ?>
    
    <? if($tipos) { ?>
    
    <label class="normal">Categorias a que o produto pertence:</label>
    
    <? foreach($tipos as $tipo) { ?>
    
    <input class="adjacent" type="checkbox" name="tipos[]" value="<?= $tipo->id ?>" id="tipo_<?= $tipo->id ?>" <? if($obj->temTipo($tipo->id)) { ?>checked="checked"<? } ?>  />
    <label class="adjacent" for="tipo_<?= $tipo->id ?>"><?= $tipo->nome ?></label>
    
    <? } ?>
    <br />
    <? } ?>
    
    <label class="normal">Adicionais dispon�veis para o produto:</label>
    <div id="adicionais"><label class="adjacent">Escolha um restaurante primeiro</label></div>
    <br />
    <!-- medida tomada para que o fato de n�o carregar os adicionais disponiveis delete os ja cadastrados -->
    <input type="hidden" name="nao_altere_adicionais" value="1"/>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    
    <label class="normal">Pre&ccedil;o:</label>
    <input class="formfield w15" type="text" name="preco" value="<?= $obj->preco ?>" maxlength="100" />
    
    <label class="normal">Tamanho:</label>
    <input class="formfield w15" type="text" name="tamanho" value="<?= $obj->tamanho ?>" maxlength="100" />
    
    <label class="normal">Multi-sabor:</label>
    <input class="adjacent" id="aceita_segundo_sabor_sim" type="radio" name="aceita_segundo_sabor" value="1" <? if ($obj->id && $obj->aceita_segundo_sabor === 1) { ?>checked="checked"<? } ?> />
    <label class="adjacent" for="aceita_segundo_sabor_sim">Sim</label>
    <input class="adjacent" id="aceita_segundo_sabor_nao" type="radio" name="aceita_segundo_sabor" value="0" <? if (!$obj->id || $obj->aceita_segundo_sabor === 0) { ?>checked="checked"<? } ?> />
    <label class="adjacent" for="aceita_segundo_sabor_nao">N�o</label>
    
    <label class="normal">Ativo:</label>
    <input class="adjacent" id="ativo_sim" type="radio" name="ativo" value="1" <? if (!$obj->id || $obj->ativo === 1) { ?>checked="checked"<? } ?> />
    <label class="adjacent" for="ativo_sim">Sim</label>
    <input class="adjacent" id="ativo_nao" type="radio" name="ativo" value="0" <? if ($obj->id && $obj->ativo === 0) { ?>checked="checked"<? } ?> />
    <label class="adjacent" for="ativo_nao">N�o</label>
    
    <label class="normal">Dispon&iacute;vel:</label>
    <input class="adjacent" id="disponivel_sim" type="radio" name="disponivel" value="1" <? if (!$obj->id || $obj->disponivel === 1) { ?>checked="checked"<? } ?> />
    <label class="adjacent" for="disponivel_sim">Sim</label>
    <input class="adjacent" id="disponivel_nao" type="radio" name="disponivel" value="0" <? if ($obj->id && $obj->disponivel === 0) { ?>checked="checked"<? } ?> />
    <label class="adjacent" for="disponivel_nao">N�o</label>
    
    <label class="normal">Est&aacute; em Promo&ccedil;&atilde;o:</label>
    <input class="adjacent" id="esta_em_promocao_sim" type="radio" name="esta_em_promocao" value="1" <? if ($obj->id && $obj->esta_em_promocao === 1) { ?>checked="checked"<? } ?> />
    <label class="adjacent" for="esta_em_promocao_sim">Sim</label>
    <input class="adjacent" id="esta_em_promocao_nao" type="radio" name="esta_em_promocao" value="0" <? if (!$obj->id || $obj->esta_em_promocao === 0) { ?>checked="checked"<? } ?> />
    <label class="adjacent" for="esta_em_promocao_nao">N�o</label>
    
    <label class="normal">Pre&ccedil;o Promocional:</label>
    <input type="text" name="preco_promocional" value="<?= $obj->preco_promocional ?>" maxlength="100" />
    
    <label class="normal">Descri&ccedil;&atilde;o:</label>
    <input type="text" name="descricao" value="<?= $obj->descricao ?>" maxlength="100" />
    
    <label class="normal">Quantidade de Produto Adicional:</label>
    <input type="text" name="qtd_produto_adicional" value="<?= $obj->qtd_produto_adicional ?>" maxlength="100" />
    
    <label class="normal">C&oacute;digo:</label>
    <input type="text" name="codigo" value="<?= $obj->codigo ?>" maxlength="100" />
    
    <label class="normal">Texto Promo&ccedil;&atilde;o:</label>
    <input type="text" name="texto_promocao" value="<?= $obj->texto_promocao ?>" maxlength="100" />
    
    <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer_admin.php"); ?>
