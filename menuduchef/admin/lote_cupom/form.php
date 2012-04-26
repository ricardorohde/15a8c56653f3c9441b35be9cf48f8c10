<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("LoteCupom");

$restaurantes=Restaurante::all();

$now = time();
$hash_lotecupom = 'lotecupom' . $now;

?>

<script type="text/javascript">
    $(function() {
        $("#marcar_todos").click(function(){
            if($(this).attr("md")=="0"){
               $(this).attr("md","1");
               $(".mark").each(function(){
                   $(this).attr("checked",true);
               });
            }else{
                $(this).attr("md","0");
                $(".mark").each(function(){
                   $(this).removeAttr("checked");
               });
            }
        });
        $(".marcar_cid").click(function(){
            qual = $(this).attr("qual");
            if($(this).attr("md")=="0"){
               $(this).attr("md","1");
               $("."+qual).each(function(){
                   $(this).attr("checked",true);
               });
            }else{
                $(this).attr("md","0");
                $("."+qual).each(function(){
                   $(this).removeAttr("checked");
               });
            }
        });
    });
</script>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Lotes de Cupons</h2>

<a href="admin/lote_cupom/" title="Cancelar">Cancelar</a>

<form action="admin/lote_cupom/controller" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    <input type="hidden" name="edita_restaurantes_aceitam" value="1" />
    
    <label class="normal">Nome:</label>
    <input class="formfield w50" type="text" name="nome" value="<?= $obj->nome ?>" maxlength="100" />
    
    <? if($obj->id){ ?>
    <label class="normal">Validade:</label>
    <input class="formfield w50" type="datetime" value="<?= $obj->validade->format("d-m-Y H:i:s") ?>" name="validade" maxlength="100" />
    <? }else{ ?>
    <label class="normal">Validade:</label>
    <input class="formfield w50" type="datetime" value="" name="validade" maxlength="100" />
   
    <? } ?>
    
    
    <label class="normal">Restaurantes Participantes:</label>
    
    <? foreach($restaurantes as $restaurante) { ?>
    
    <input class="adjacent mark cid<?= $restaurante->cidade_id ?>" type="checkbox" name="restaurantes_aceitam[]" value="<?= $restaurante->id ?>" id="restaurante_<?= $restaurante->id ?>" <? if($obj->restauranteAceita($restaurante->id)) { ?>checked="checked"<? } ?> />
    <label class="adjacent" for="restaurante_<?= $restaurante->id ?>"><?= $restaurante->nome ?></label>
    
    <? } ?>
    <br/>
    <table style="width:100%"><tr>
    <?
        $ncid = 0;
        $cidades=Cidade::all(array("conditions"=>array("ativa = ?",1)));
        if($cidades){
            foreach($cidades as $cidade){ 
                $ncid++;
                ?>
                <td><input type="button" class="marcar_cid" md="0" qual="cid<?= $cidade->id ?>" value="<?= $cidade->nome ?>/<?= $cidade->uf->sigla ?>"></td>
           <? }
        }
    ?>
                </tr>
                <tr><td <?= $ncid>0 ? "colspan='".$ncid."'" : "" ?>>
    <input type="button" id="marcar_todos" md="0"  value="Marcar/Desmarcar Todos">
    </td></tr>
    </table>
    <br/><br/>
    <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer_admin.php"); ?>
