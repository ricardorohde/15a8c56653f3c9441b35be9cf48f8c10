<?
include('../../include/header_admin.php');

$itens = Cupom::all(array("order" => "id asc"));
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Cupons</h2>

<a href="admin/cupom/form" title="Criar">Criar</a> --- <a href="admin/cupom/form_emmassa" title="Criar em Massa">Criar em Massa</a>
<br /><br />

<table class="list">
    <tr>
	<th>Cupom</th>
        <th>Lote</th>
	<th>Valor</th>
	<th>Validade</th>
        <th>Status</th>
        <th>Rest.</th>
        <th>Adm.</th>
	<th width="10%"></th>
	<th width="10%"></th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->codigo ?></td>
                <td><?= $item->lote_cupom ? $item->lote_cupom->nome : "" ?></td>
		<td><?= $item->valor ?></td>
		<td><?= $item->lote_cupom ? $item->lote_cupom->validade->format("d/m/Y - H:i:s") : "" ?></td>
                <td><? 
                    
                        if($item->usado==1){
                            echo "USADO";
                        } 
                    
                    ?></td>
                <td><? 
                        if($item->usado==1){
                            echo $item->pedido->restaurante->nome;
                        } 
                    ?></td>
                <td><? 
                        
                            echo $item->administrador->usuario->nome;
                        
                    ?></td>
		<td align="center"><a href="admin/cupom/form/<?= $item->id ?>">Modificar</a></td>
		<td align="center"><a href="admin/cupom/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="9">Nenhum cupom cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer_admin.php"); ?>
