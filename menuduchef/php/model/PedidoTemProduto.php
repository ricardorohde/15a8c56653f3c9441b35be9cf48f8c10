<?

class PedidoTemProduto extends ActiveRecord\Model {
	static $table_name = "pedido_tem_produto";
	static $belongs_to = array(
		array("pedido", "foreign_key" => "pedido_id"),
                array("produto", "foreign_key" => "produto_id"),
                array("produto2", "foreign_key" => "produto_id2", "class_name" => "Produto"),
                array("produto3", "foreign_key" => "produto_id3", "class_name" => "Produto"),
                array("produto4", "foreign_key" => "produto_id4", "class_name" => "Produto")
	);
        static $has_many = array(
	    array("pedido_tem_produtos_adicionais", "foreign_key" => "pedidotemproduto_id", "class_name" => "PedidoTemProdutoAdicional"),
            array("produtos_adicionais", 'through' => 'pedido_tem_produtos_adicionais', "foreign_key" => "pedidotemproduto_id", "class_name" => "ProdutoAdicional")
	);
}

?>