<?
include("../../include/header.php");

$itens = Consumidor::all(array("order" => "nome asc"));
?>

<h2>Gerenciar Consumidores</h2>

<a href="admin/" title="Menu principal">Menu principal</a>
<br /><br />

<a href="admin/consumidor/form" title="Criar">Criar</a>
<br /><br />

<table>
    <tr>
	<th>Nome</th>
	<th>Cidade</th>
	<th>Bairro</th>
	<th>Modificar</th>
	<th>Excluir</th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->nome ?></td>
		<td><?= $item->bairro->cidade->nome ?></td>
		<td><?= $item->bairro->nome ?></td>
		<td><a href="admin/consumidor/form/<?= $item->id ?>">Modificar</a></td>
		<td><a href="admin/consumidor/controller?deleteId=<?= $item->id ?>&action=delete" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="3">Nenhum consumidor cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer.php"); ?>