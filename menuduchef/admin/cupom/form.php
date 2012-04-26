<?
include('../../include/header_admin.php');

$obj = HttpUtil::getActiveRecordObjectBySessionOrGetId("Cupom");

$lotes = LoteCupom::all();
$usuario_obj = unserialize($_SESSION['usuario_obj']);
$pedidos = Pedido::all(array("conditions"=>array("cupom = ? ","")));

?>

<script type="text/javascript">
    $(function() {
        
    });
</script>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Cupons</h2>

<a href="admin/cupom/" title="Cancelar">Cancelar</a>

<form action="admin/cupom/controller" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $obj->id ?>" />
    <input type="hidden" name="administrador_id" value="<?= $usuario_obj->id ?>" />
        
    <label class="normal">C&oacute;digo:</label>
    <input class="formfield w50" type="text" name="codigo" value="<?= $obj->codigo ?>" maxlength="100" />
    
    <label class="normal">Lote:</label>
    <? if($obj->lote_cupom) { ?>
	<label class="adjacent"><?= $obj->lote_cupom->nome ?></label>
        <input type="hidden" id="cidades" value="<?= $obj->lotecupom_id ?>" />
    <? } else { ?>
        <select class="formfield w40" id="lotes" name="lotecupom_id">
            <option value="">-- Selecione --</option>
            <?
            if ($lotes) {
                foreach ($lotes as $lote) {
                    ?>
                    <option value="<?= $lote->id ?>" <? if ($lote->id == $obj->lotecupom_id) { ?>selected="selected"<? } ?>><?= $lote->nome ?></option>
                <? }
            } ?>
        </select>
    <? } ?>

    <label class="normal">Valor:</label>
    <input class="formfield w50" type="text" name="valor" value="<?= $obj->valor ?>" maxlength="100" /><br /><br />

    <label class="normal">Usado:</label>
    <input class="adjacent" id="usado_sim" type="radio" name="usado" value="1" <? if (!$obj->id && $obj->usado === 1) { ?>checked="checked"<? } ?> />
    <label class="adjacent" for="usado_sim">Sim</label>
    <input class="adjacent" id="usado_nao" type="radio" name="usado" value="0" <? if ($obj->id || $obj->usado === 0) { ?>checked="checked"<? } ?> />
    <label class="adjacent" for="usado_nao">Não</label>
	
    <label class="normal">Pedido em que foi usado:</label>
    <select class="formfield w40" name="pedido_id">
	<option value="">-- Nenhum --</option>
	<?
	if ($pedidos) {
	    foreach ($pedidos as $ped) {
		?>
		<option value="<?= $ped->id ?>" <? if ($ped->id == $obj->pedido_id) { ?>selected="selected"<? } ?>><?= $ped->id."#  ".$ped->consumidor->usuario->nome." - ".$ped->restaurante->nome ?></option>
	    <? }
	} ?>
    </select>

    
    <input class="btn" type="submit" value="<?= $obj->id ? "Modificar" : "Criar" ?>" />
</form>

<? include("../../include/footer_admin.php"); ?>
