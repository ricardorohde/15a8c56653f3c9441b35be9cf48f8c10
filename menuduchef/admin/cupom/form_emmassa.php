<?
include('../../include/header_admin.php');



$lotes = LoteCupom::all();
$usuario_obj = unserialize($_SESSION['usuario_obj']);

?>

<script type="text/javascript">
    $(function() {
        
    });
</script>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerar Cupons em Massa</h2>

<a href="admin/cupom/" title="Cancelar">Cancelar</a>

<form action="admin/cupom_emmassa/controller" method="post" enctype="multipart/form-data">
    <input type="hidden" name="administrador_id" value="<?= $usuario_obj->id ?>" />
            
    <label class="normal">Lote:</label>

        <select class="formfield w40" id="lotes" name="lotecupom_id">
            <option value="">-- Selecione --</option>
            <?
            if ($lotes) {
                foreach ($lotes as $lote) {
                    if(!$lote->cupons[0]){
                    ?>
                    <option value="<?= $lote->id ?>" <? if ($lote->id == $obj->lotecupom_id) { ?>selected="selected"<? } ?>><?= $lote->nome ?></option>
                <? }
                }
            } ?>
        </select>


    <label class="normal">Valor:</label>
    <input class="formfield w50" type="text" name="valor" value="" maxlength="100" /><br /><br />

    <label class="normal">Quantidade:</label>
    <input class="formfield w50" type="text" name="qtd" value="" maxlength="100" /><br /><br />

    
    <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer_admin.php"); ?>
