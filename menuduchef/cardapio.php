<?

//$itens = Produto::all(array("order" => "nome asc", "conditions" => array("restaurante_id = ?",$_GET['res'])));
$categorias = RestauranteTemTipoProduto::all(array("order" => "nome asc", "conditions" => array("restaurante_id = ?",$_GET['res'])));
?>

<table class="list">
    <? if($categorias){
            foreach($categorias as $categoria){ ?>
                <tr><th><?= $categoria->tipo_produto->nome ?></th></tr>
            <? 
                $itens = Produto::find_by_sql("SELECT * FROM produto P INNER JOIN produto_tem_tipo PTT ON P.id = PTT.produto_id INNER JOIN restaurante_tem_tipo_produto RTTP ON PTT.tipoproduto_id = RTTP.tipoproduto_id WHERE RTTP.restaurante_id = ".$_GET['res']." AND PTT.tipoproduto_id = ".$categoria->nome." ORDER BY P.nome asc");
                if($itens){
                    foreach($itens as $item){ ?>
                           <tr><th><?= $item->nome ?></th></tr>
                   <? }
                }
            }
        
    } ?>
    <tr>
	<th>Nome</th>
        <th>Tamanho</th>
 
        <th>Pre&ccedil;o</th>
    </tr>
    <?
    if ($itens) {
	foreach ($itens as $item) {
	    ?>
	    <tr>
		<td><?= $item->nome ?></td>
                <td><?= $item->tamanho ?></td>
		<td><?= $item->getPrecoFormatado() ?></td>
                

		
	    </tr>
	    <?
	}
    } else {
	?>
    <tr>
	<td colspan="19">Nenhum produto cadastrado</td>
    </tr>
    <? } ?>
</table>

<? include("../../include/footer.php"); ?>