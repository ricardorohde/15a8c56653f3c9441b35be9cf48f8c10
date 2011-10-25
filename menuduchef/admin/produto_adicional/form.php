<?
include("../../include/header.php");

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("ProdutoAdicional");

$restaurantes = Restaurante::all(array("order" => "nome asc"));
?>

<? include("../../include/painel_area_administrativa.php") ;?>

<h2><a href="admin/">Menu Principal</a> &raquo; Gerenciar Produtos Adicionais</h2>

<a href="admin/produto_adicional/" title="Cancelar">Cancelar</a>
<br /><br />

<form action="admin/produto_adicional/controller" method="post">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    Nome<br />
    <input type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" /><br /><br />
    Restaurante<br /><? if($obj->restaurante_id){ 
         echo $obj->restaurante->nome;  
      }else{ ?>
    <select name="restaurante_id">-- Selecione --</option>
	<?
	if ($restaurantes) {
	    foreach ($restaurantes as $restaurante) {
		?>
		<option value="<?= $restaurante->id ?>" <? if ($restaurante->id == $obj->restaurante_id) { ?>selected="true"<? } ?>><?= $restaurante->nome ?></option>
	    <? }
	} ?>
    </select>
    <? } ?>
    <br /><br />
    Pre&ccedil;o Adicional<br />
    <input type="text" name="preco_adicional" value="<?= $obj->preco_adicional ?>" maxlength="100" /><br /><br />
    Ativo<br />
    <input type="radio" name="ativo" value="1" <? if (!$obj->id || $obj->ativo === 1) { ?>checked="true"<? } ?> />Sim
    <input type="radio" name="ativo" value="0" <? if ($obj->id && $obj->ativo === 0) { ?>checked="true"<? } ?> />Não
    <br /><br />
    Dispon&iacute;vel<br />
    <input type="radio" name="disponivel" value="1" <? if (!$obj->id || $obj->disponivel === 1) { ?>checked="true"<? } ?> />Sim
    <input type="radio" name="disponivel" value="0" <? if ($obj->id && $obj->disponivel === 0) { ?>checked="true"<? } ?> />Não
    <br /><br />
    Quantas Unidades Ocupa<br />
    <input type="text" name="quantas_unidades_ocupa" value="<?= $obj->quantas_unidades_ocupa ?>" maxlength="100" /><br /><br />
    
    
    <input type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer.php"); ?>