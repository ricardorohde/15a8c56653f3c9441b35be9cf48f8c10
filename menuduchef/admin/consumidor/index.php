<?
include('../../include/header_admin.php');

$itens = Consumidor::all();
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Clientes</h2>

<a href="admin/consumidor/form" title="Criar">Criar</a>
<br /><br />

<table class="list">
    <tr>
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
		<td><?= $item->nome ?></td>
                <td><?= $item->email ?></td>
                <td><?= $item->cpf ?></td>
                <td><?= $item->data_nascimento ?></td>
                <td><?= $item->sexo ?></td>
                <td><?
                $telc = 0;
                foreach($item->telefones as $telefone){
                   
                    if($telc==0){
                        echo $telefone->numero;
                    }
                    $telc++;
                } 
                
                ?></td>
                <td><?
                foreach($item->enderecos as $endereco){
                    if($endereco->favorito){
                        echo $endereco->logradouro;
                    }
                }        
                ?></td>
		<td><? 
                foreach($item->enderecos as $endereco){
                    if($endereco->favorito){
                        echo $endereco->bairro->nome;
                    }
                }  
                ?></td>
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

<? include("../../include/footer_admin.php"); ?>