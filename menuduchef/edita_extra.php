<?
session_start();

include("include/header.php");

$_SESSION['restaurante_editado_id'] = 1;

if($_SESSION['restaurante_editado_id']){
    $restaurante = $_SESSION['restaurante_editado_id'];
    $acomps = ProdutoAdicional::all(array("conditions" => array("restaurante_id = ? AND quantas_unidades_ocupa > ? AND ativo = ?",$restaurante,0,1)));
    $porcoes = ProdutoAdicional::all(array("conditions" => array("restaurante_id = ? AND quantas_unidades_ocupa = ? AND ativo = ?",$restaurante,0,1)));
}
?>

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/mask.js"></script>

<script>

$(document).ready(function() {
    
    num_adi = 0;

    $("#porcoes").append("<tr id='novo_adicional_"+num_adi+"'><input type='hidden' name='novo_quantas_unidades_ocupa_"+num_adi+"' value='0'><th><input type='text' id='novo_nome_"+num_adi+"' name='novo_nome_"+num_adi+"' style='width:60px;' value=''></th><th><div style='position:relative; float: left;'>R$</div><div><input type='text' name='novo_preco_adicional_"+num_adi+"' style='width:50px; position:relative; float: left;' onkeyup='mask_moeda(this)' value='0,00'></div></th><th><div style='width:40px;'><input type='radio' name='novo_disponivel_"+num_adi+"' value='1' checked > Sim<br/><input type='radio' name='novo_disponivel_"+num_adi+"' value='0'> N&atilde;o</div></th><th><input type='hidden' id='novo_ativo_"+num_adi+"' name='novo_ativo_"+num_adi+"' value='1'><input type='button' class='botao_remove_novo_adicional' qual='"+num_adi+"' value='x'></th></tr>");
    num_adi++;
    
    $("#add_porcao").click( function(){
        $("#porcoes").append("<tr id='novo_adicional_"+num_adi+"'><input type='hidden' name='novo_quantas_unidades_ocupa_"+num_adi+"' value='0'><th><input type='text' id='novo_nome_"+num_adi+"' name='novo_nome_"+num_adi+"' style='width:60px;' value=''></th><th><div style='position:relative; float: left;'>R$</div><div><input type='text' name='novo_preco_adicional_"+num_adi+"' style='width:50px; position:relative; float: left;' onkeyup='mask_moeda(this)' value='0,00'></div></th><th><div style='width:40px;'><input type='radio' name='novo_disponivel_"+num_adi+"' value='1' checked > Sim<br/><input type='radio' name='novo_disponivel_"+num_adi+"' value='0'> N&atilde;o</div></th><th><input type='hidden' id='novo_ativo_"+num_adi+"' name='novo_ativo_"+num_adi+"' value='1'><input type='button' class='botao_remove_novo_adicional' qual='"+num_adi+"' value='x'></th></tr>");
        num_adi++;
    });

    $(".botao_remove_novo_adicional").click( function(){
        alert("HAI");
        //qual = $(this).attr("qual");
        //$("#"+qual).remove();
    });
    
    //$("#porcoes").append("<tr id='novo_adicional_"+num_adi+"'><input type='hidden' name='novo_quantas_unidades_ocupa_"+num_adi+"' value='0'><th><input type='text' id='novo_nome_"+num_adi+"' name='novo_nome_"+num_adi+"' style='width:60px;' value=''></th><th><div style='position:relative; float: left;'>R$</div><div><input type='text' name='novo_preco_adicional_"+num_adi+"' style='width:50px; position:relative; float: left;' onkeyup='mask_moeda(this)' value='0,00'></div></th><th><div style='width:40px;'><input type='radio' name='novo_disponivel_"+num_adi+"' value='1' checked > Sim<br/><input type='radio' name='novo_disponivel_"+num_adi+"' value='0'> N&atilde;o</div></th><th><input type='hidden' id='novo_ativo_"+num_adi+"' name='novo_ativo_"+num_adi+"' value='1'><input type='button' class='desativar_novo' qual='"+num_adi+"' value='x"+num_adi+"'></th></tr>");
    $(".desativar").click( function(){
        qual = $(this).attr("qual");
        nome = $("#nome_"+qual).attr("value");
        con = confirm("Tem certeza que deseja excluir "+nome+"?");
        if(con){    
            $("#adicional_"+qual).hide();
            $("#ativo_"+qual).value = 0;
        }
    });
    
    
    
    

    
    
    
    
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
<div>
    <div style="float:left; position: relative; padding-left: 20px; padding-right: 50px;">
        <table class="list">
            <tr><td><input type="button" value="Salvar Altera&ccedil;&otilde;es"></td></tr>
            <tr><td><input type="button" onclick="location.href=('edita_extra.php');" value="Cancelar"></td></tr> 
            <tr><td><input type="button" value="Voltar"></td></tr>
        </table>
    </div>
    
    <div style="float:left; position: relative; width: 350px; font-size: 11px;">
    <table class="list">
        <tr><th colspan="6">Acompanhamentos</th></tr>
        <tr>
            <th>Nome</th>
            <th>Pre&ccedil;o Adicional</th>
            <th>Dispon&iacute;vel no momento</th>
            <th>Ocupa quantas unidades</th>
            <th>x</th>
        </tr>
        <?

        if($acomps){
            foreach($acomps as $item){ ?>
                <tr id="adicional_<?= $item->id ?>">
                    <th><input type="text" id="nome_<?= $item->id ?>" name="nome_<?= $item->id ?>" style="width:60px;" value='<?= $item->nome ?>'></th>
                    <th><div style="position:relative; float: left;">R$</div><div><input type="text" name="preco_adicional_<?= $item->id ?>" style="width:50px; position:relative; float: left;" onkeyup="mask_moeda(this)" value='<?= $item->preco_adicional ?>'></div></th>
                    <th><div style="width:40px;"><input type="radio" name="disponivel_<?= $item->id ?>" value="1" <?= $item->disponivel ? "checked" : "" ?> > Sim<br/><input type="radio" name="disponivel_<?= $item->id ?>" value="0" <?= $item->disponivel ? "" : "checked" ?> > N&atilde;o</div></th>
                    <th><input type="text" name="quantas_unidades_ocupa_<?= $item->id ?>" style="width:20px;" value='<?= $item->quantas_unidades_ocupa ?>'></th>
                    <th><input type="hidden" id="ativo_<?= $item->id ?>" name="ativo_<?= $item->id ?>" value="1"><input type="button" class="desativar" qual="<?= $item->id ?>" value="x"></th>
                </tr>
           <? }
        }?>
    </table>
    </div>
    
    <div style="float:left; position: relative; width: 350px; font-size: 11px;">
    <table class="list" id="porcoes">
        <tr><th colspan="4">Por&ccedil;&otilde;es Extras</th></tr>
        <tr>
            <th>Nome</th>
            <th>Pre&ccedil;o Adicional</th>
            <th>Dispon&iacute;vel no momento</th>
            <th>x</th>
        </tr>
        <?

        if($porcoes){
            foreach($porcoes as $item){ ?>
                <tr id="adicional_<?= $item->id ?>">
                    <input type="hidden" name="quantas_unidades_ocupa_<?= $item->id ?>" value="0">
                    <th><input type="text" id="nome_<?= $item->id ?>" name="nome_<?= $item->id ?>" style="width:60px;" value='<?= $item->nome ?>'></th>
                    <th><div style="position:relative; float: left;">R$</div><div><input type="text" name="preco_adicional_<?= $item->id ?>" style="width:50px; position:relative; float: left;" onkeyup="mask_moeda(this)" value='<?= $item->preco_adicional ?>'></div></th>
                    <th><div style="width:40px;"><input type="radio" name="disponivel_<?= $item->id ?>" value="1" <?= $item->disponivel ? "checked" : "" ?> > Sim<br/><input type="radio" name="disponivel_<?= $item->id ?>" value="0" <?= $item->disponivel ? "" : "checked" ?> > N&atilde;o</div></th>
                    <th><input type="hidden" id="ativo_<?= $item->id ?>" name="ativo_<?= $item->id ?>" value="1"><input type="button" class="desativar" qual="<?= $item->id ?>" value="x"></th>
                </tr>
           <? }
        }?>
        
        <tr><th colspan="4">Criar novo <input type="button" id="add_porcao" qual="porcoes" value=" + "></th></tr>
    </table>
    </div>
    
</div>
<? include("include/footer.php"); ?>