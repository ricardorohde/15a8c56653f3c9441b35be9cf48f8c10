<?
session_start();

include("include/header2.php");

if($_SESSION['restaurante_id']){
    $restaurante = $_SESSION['restaurante_id'];
    $acomps = ProdutoAdicional::all(array("conditions" => array("restaurante_id = ? AND quantas_unidades_ocupa > ? AND ativo = ?",$restaurante,0,1)));
    $porcoes = ProdutoAdicional::all(array("conditions" => array("restaurante_id = ? AND quantas_unidades_ocupa = ? AND ativo = ?",$restaurante,0,1)));
    $usuario = unserialize($_SESSION['usuario']);
    
    
}
?>

<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="js/mask.js"></script>

<script>

$(document).ready(function() {
    
    num_adi = 0;
    
    $("#add_porcao").click( function(){
        $("#porcoes").append("<tr id='novo_adicional-"+num_adi+"'><input type='hidden' name='novo_quantas_unidades_ocupa-"+num_adi+"' value='0'><th><input type='text' id='novo_nome-"+num_adi+"' name='novo_nome-"+num_adi+"' style='width:60px;' value=''></th><th><div style='position:relative; float: left;'>R$</div><div><input type='text' name='novo_preco_adicional-"+num_adi+"' style='width:50px; position:relative; float: left;' onkeyup='mask_moeda(this)' value='0,00'></div></th><th><div style='width:40px;'><input type='radio' name='novo_disponivel-"+num_adi+"' value='1' checked > Sim<br/><input type='radio' name='novo_disponivel-"+num_adi+"' value='0'> N&atilde;o</div></th><th><input type='hidden' id='novo_ativo-"+num_adi+"' name='novo_ativo-"+num_adi+"' value='1'><input type='button' class='botao_remove_novo_adicional' qual='"+num_adi+"' value='x'></th></tr>");
        num_adi++;
        
        $(".botao_remove_novo_adicional").click( function(){
            qual = $(this).attr("qual");
            $("#novo_adicional-"+qual).remove();
        });
    });
    
    $("#add_acompanhamento").click( function(){
        $("#acompanhamentos").append("<tr id='novo_adicional-"+num_adi+"'><th><input type='text' id='novo_nome-"+num_adi+"' name='novo_nome-"+num_adi+"' style='width:60px;' value=''></th><th><div style='position:relative; float: left;'>R$</div><div><input type='text' name='novo_preco_adicional-"+num_adi+"' style='width:50px; position:relative; float: left;' onkeyup='mask_moeda(this)' value='0,00'></div></th><th><div style='width:40px;'><input type='radio' name='novo_disponivel-"+num_adi+"' value='1' checked > Sim<br/><input type='radio' name='novo_disponivel-"+num_adi+"' value='0'> N&atilde;o</div></th><th><input type='text' name='novo_quantas_unidades_ocupa-"+num_adi+"' style='width:50px; position:relative; float: left;' value='1'></th><th><input type='hidden' id='novo_ativo-"+num_adi+"' name='novo_ativo-"+num_adi+"' value='1'><input type='button' class='botao_remove_novo_adicional' qual='"+num_adi+"' value='x'></th></tr>");
        num_adi++;
        
        $(".botao_remove_novo_adicional").click( function(){
            qual = $(this).attr("qual");
            $("#novo_adicional-"+qual).remove();
        });
    });

    
    
    //$("#porcoes").append("<tr id='novo_adicional-"+num_adi+"'><input type='hidden' name='novo_quantas_unidades_ocupa-"+num_adi+"' value='0'><th><input type='text' id='novo_nome-"+num_adi+"' name='novo_nome-"+num_adi+"' style='width:60px;' value=''></th><th><div style='position:relative; float: left;'>R$</div><div><input type='text' name='novo_preco_adicional-"+num_adi+"' style='width:50px; position:relative; float: left;' onkeyup='mask_moeda(this)' value='0,00'></div></th><th><div style='width:40px;'><input type='radio' name='novo_disponivel-"+num_adi+"' value='1' checked > Sim<br/><input type='radio' name='novo_disponivel-"+num_adi+"' value='0'> N&atilde;o</div></th><th><input type='hidden' id='novo_ativo-"+num_adi+"' name='novo_ativo-"+num_adi+"' value='1'><input type='button' class='desativar_novo' qual='"+num_adi+"' value='x"+num_adi+"'></th></tr>");
    $(".desativar").click( function(){
        qual = $(this).attr("qual");
        nome = $("#nome-"+qual).attr("value");
        con = confirm("Tem certeza que deseja excluir "+nome+"?");
        if(con){    
            $("#adicional-"+qual).hide();
            $("#ativo-"+qual).attr("value",0);
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
<form action="php/controller/salva_cardapio_extra" method="post">
<div >
    Ol&aacute;, <b><?= $usuario->nome ?></b>. Seja bem vindo ao painel do <b><?= $restaurante ?></b>.
    <div style="float:left; position: relative; padding-left: 20px; padding-right: 50px;">
        <table border="1">
            <tr><td><input type="submit" value="Salvar Altera&ccedil;&otilde;es"></td></tr>
            <tr><td><input type="button" onclick="location.href=('edita_extra');" value="Cancelar"></td></tr> 
            <tr><td><input type="button" onclick="location.href=('area_adm_restaurante');" value="Voltar"></td></tr>
        </table>
    </div>
    
    <div style="float:left; position: relative; width: 350px; font-size: 11px;">
    <table border="1" id="acompanhamentos">
        <tr><th colspan="5">Acompanhamentos</th></tr>
        <tr>
            <th>Nome</th>
            <th>Pre&ccedil;o Adicional</th>
            <th>Dispon&iacute;vel no momento</th>
            <th>Ocupa quantas unidades</th>
            <th>x</th>
        </tr>
        <?
        $countad = 0;
        if($acomps){
            foreach($acomps as $item){ ?>
                <tr id="adicional-<?= $countad ?>">
                    <input type="hidden" name="id-<?= $countad ?>" value="<?= $item->id ?>">
                    <th><input type="text" id="nome-<?= $countad ?>" name="nome-<?= $countad ?>" style="width:60px;" value='<?= $item->nome ?>'></th>
                    <th><div style="position:relative; float: left;">R$</div><div><input type="text" name="preco_adicional-<?= $countad ?>" style="width:50px; position:relative; float: left;" onkeyup="mask_moeda(this)" value='<?= $item->preco_adicional ?>'></div></th>
                    <th><div style="width:40px;"><input type="radio" name="disponivel-<?= $countad ?>" value="1" <?= $item->disponivel ? "checked" : "" ?> > Sim<br/><input type="radio" name="disponivel-<?= $countad ?>" value="0" <?= $item->disponivel ? "" : "checked" ?> > N&atilde;o</div></th>
                    <th><input type="text" name="quantas_unidades_ocupa-<?= $countad ?>" style="width:20px;" value='<?= $item->quantas_unidades_ocupa ?>'></th>
                    <th><input type="hidden" id="ativo-<?= $countad ?>" name="ativo-<?= $countad ?>" value="1"><input type="button" class="desativar" qual="<?= $countad ?>" value="x"></th>
                </tr>
           <? $countad++; }
        }?>
        <tr><th colspan="5">Criar novo <input type="button" id="add_acompanhamento" qual="acompanhamentos" value=" + "></th></tr>
    </table>
    </div>
    
    <div style="float:left; position: relative; width: 350px; font-size: 11px;">
    <table border="1" id="porcoes">
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
                <tr id="adicional-<?= $countad ?>">
                    <input type="hidden" name="quantas_unidades_ocupa-<?= $countad ?>" value="0">
                    <input type="hidden" name="id-<?= $countad ?>" value="<?= $item->id ?>">
                    <th><input type="text" id="nome-<?= $countad ?>" name="nome-<?= $countad ?>" style="width:60px;" value='<?= $item->nome ?>'></th>
                    <th><div style="position:relative; float: left;">R$</div><div><input type="text" name="preco_adicional-<?= $countad ?>" style="width:50px; position:relative; float: left;" onkeyup="mask_moeda(this)" value='<?= $item->preco_adicional ?>'></div></th>
                    <th><div style="width:40px;"><input type="radio" name="disponivel-<?= $countad ?>" value="1" <?= $item->disponivel ? "checked" : "" ?> > Sim<br/><input type="radio" name="disponivel-<?= $countad ?>" value="0" <?= $item->disponivel ? "" : "checked" ?> > N&atilde;o</div></th>
                    <th><input type="hidden" id="ativo-<?= $countad ?>" name="ativo-<?= $countad ?>" value="1"><input type="button" class="desativar" qual="<?= $countad ?>" value="x"></th>
                </tr>
           <? $countad++; }
        }?>
        
        <tr><th colspan="4">Criar novo <input type="button" id="add_porcao" qual="porcoes" value=" + "></th></tr>
    </table>
    </div>
    
</div>
</form>
<? include("include/footer.php"); ?>