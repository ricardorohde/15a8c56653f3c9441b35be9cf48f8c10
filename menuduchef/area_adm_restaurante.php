<?
session_start();

include("include/header2.php");


if($_SESSION['restaurante_id']){
    $restaurante = $_SESSION['restaurante_id'];
    $cidade = $_SESSION['cidade_id'];
    $rest = Restaurante::find($restaurante);
}

$usuario = unserialize($_SESSION['usuario']);
$usuobj = unserialize($_SESSION['usuario_obj']);
$obj = Restaurante::find($usuobj->restaurante_id);
$tipos = TipoRestaurante::all();
$tipos_produto = TipoProduto::all();
$bairros = Bairro::all(array("conditions"=>array("cidade_id = ?",$cidade)));
?>

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/mask.js"></script>

<script>

$(document).ready(function() {
    
});

function show(x){
    oque = document.getElementById(x);
    if(oque.style.display == "block"){
        oque.style.display = "none";
    }else{
        oque.style.display = "block";
    }
}
</script>
Ol&aacute;, <b><?= $usuario->nome ?></b>. Seja bem vindo ao painel do <b><?= $rest->nome ?></b>.
<div>
    <div style="float:left; position: relative; padding-left: 20px; padding-right: 50px;">
        <table class="list">
            <tr><td><input type="button" value="Salvar Altera&ccedil;&otilde;es"></td></tr>
            <tr><td><input type="button" onclick="location.href=('area_adm_restaurante');" value="Cancelar"></td></tr>
            <tr><td><input type="submit" value="Sair"></td></tr>
        </table>
    </div>
    
    <div style="float:left; position: relative; width: 700px; font-size: 11px;">
        <form action="admin/restaurante/controller" method="post">
            <input type="hidden" name="id" value="<?= $obj->id ?>" />

            <label class="normal">Nome:</label>
            <input class="formfield w50" type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" />

            <label class="normal">Cidade:</label>
            
            <label class="adjacent"><?= $obj->cidade->nome ?></label>
            <input type="hidden" id="cidades" value="<?= $obj->cidade_id ?>" />

            <label class="normal">Endereço:</label>
            <input class="formfield w50" type="text" name="endereco" value="<?= $obj->endereco ?>" maxlength="100" /><br /><br />

            <label class="normal">Pizzas podem ser divididas em quantos sabores (&uacute;til apenas para quem vende pizzas):</label>
            <select class="formfield w20" name="qtd_max_sabores">
                <option value="">-- Selecione --</option>

                <option value="2" <? if (2 == $obj->qtd_max_sabores) { ?>selected="selected"<? } ?>>2</option>
                <option value="3" <? if (3 == $obj->qtd_max_sabores) { ?>selected="selected"<? } ?>>3</option>
                <option value="4" <? if (4 == $obj->qtd_max_sabores) { ?>selected="selected"<? } ?>>4</option>
            </select>

            <label class="normal">Bairros que o restaurante atende:</label>
            <div id="bairros">
                <? if($bairros){
                    foreach($bairros as $bairro){
                        $atende = "";
                        $atendes=RestauranteAtendeBairro::all(array("conditions"=>array("restaurante_id = ? AND bairro_id = ?",$obj->id,$bairro->id)));
                        foreach($atendes as $atende){
                        }
                        ?>
                        <input class="adjacent" type="checkbox" name="bairros[]" value="<?= $bairro->id ?>" id="bairro_id_<?= $bairro->id ?>" <? if($obj->atendeBairro($bairro->id)) { ?>checked="checked"<? } ?> />
                        <label class="adjacent" for="bairro_id_<?= $bairro->id ?>"><?= $bairro->nome ?></label> => Taxa de Entrega: <input type="text" value="<? if($atende){ echo $atende->preco_entrega; } ?>" > => Tempo de Entrega: <input type="text" value="<? if($atende){ echo $atende->tempo_entrega; } ?>" >
                        <br/>
                   <? }
                } ?>
            </div>

            <? if($tipos) { ?>

            <label class="normal">Categorias de restaurante:</label>

            <? foreach($tipos as $tipo) { ?>

            <input class="adjacent" type="checkbox" name="tipos[]" value="<?= $tipo->id ?>" id="tiporestaurante_id_<?= $tipo->id ?>" <? if($obj->temTipo($tipo->id)) { ?>checked="checked"<? } ?> />
            <label class="adjacent" for="tiporestaurante_id_<?= $tipo->id ?>"><?= $tipo->nome ?></label>

            <? } } ?>

            <? if($tipos_produto) { ?>

            <label class="normal">Categorias de produtos:</label>

            <? foreach($tipos_produto as $tipo_produto) { ?>

            <input class="adjacent" type="checkbox" name="tipos_produto[]" value="<?= $tipo_produto->id ?>" id="tipo_produto_<?= $tipo_produto->id ?>" <? if($obj->temTipoProduto($tipo_produto->id)) { ?>checked="checked"<? } ?> />
            <label class="adjacent" for="tipo_produto_<?= $tipo_produto->id ?>"><?= $tipo_produto->nome ?></label>

            <? } } ?>

            <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
        </form>
    </div>
    <input type="button" onclick="location.href=('edita_cardapio');" value="Editar Card&aacute;pio">
    <input type="button" onclick="location.href=('edita_extra');" value="Editar Acompanhamentos e Por&ccedil;&otilde;es Extras">
</div>
<? include("include/footer.php"); ?>