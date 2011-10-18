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
        <th>Login</th>
	<th>Nome</th>
        <th>E-mail</th>
        <th>CPF</th>
        <th>Data de Nascimento</th>
        <th>Sexo</th>
        <th>Telefone</th>
	<th>Endere&ccedil;o</th>
        <th>Bairro</th>
	<th>Modificar</th>
	<th>Excluir</th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
                <td><?= $item->login ?></td>
		<td><?= $item->nome ?></td>
                <td><?= $item->email ?></td>
                <td><?= $item->cpf ?></td>
                <td><?= $item->data_nascimento ?></td>
                <td><?= $item->sexo ?></td>
                <td><?= $item->telefones->numero ?></td>
                <td><?= $item->enderecos->logradouro ?></td>
		<td><?= $item->enderecos->bairro ?></td>
		<td><a href="admin/consumidor/form/<?= $item->id ?>">Modificar</a></td>
		<td><a href="admin/consumidor/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclusão?')">Excluir</a></td>
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