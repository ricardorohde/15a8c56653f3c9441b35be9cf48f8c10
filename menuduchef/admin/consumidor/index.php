<?
include('../../include/header_admin.php');

$itens = Consumidor::all();
?>

<h2><a href="admin/area_administrativa">Menu Principal</a> &raquo; Gerenciar Clientes</h2>

<a href="admin/consumidor/form" title="Criar">Criar</a>
<br /><br />

<table class="list w100">
    <tr>
	<th>Nome</th>
        <th>Telefone</th>
	<th>Endere&ccedil;o</th>
	<th width="10%"></th>
	<th width="10%"></th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->nome ?></td>
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
                        echo $endereco;
                    }
                }        
                ?>
		<td align="center"><a href="admin/consumidor/form/<?= $item->id ?>">Modificar</a></td>
		<td align="center"><a href="admin/consumidor/controller?deleteId=<?= $item->id ?>" onclick="return window.confirm('Confirmar exclus�o?')">Excluir</a></td>
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
