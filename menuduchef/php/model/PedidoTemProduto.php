<?

class PedidoTemProduto extends ActiveRecord\Model {
	static $table_name = "pedido_tem_produto";
	static $belongs_to = array(
		array("pedido", "foreign_key" => "id_pedido"),
                array("produto", "foreign_key" => "id_produto"),
                array("produto2", "foreign_key" => "id_produto2")
	);
        static $has_many = array(
	    array("pedido_tem_produtos_adicionais", "foreign_key" => "id_pedido_tem_produto", "class_name" => "PedidoTemProdutoAdicional"),
            array("pedido_tem_produtos_adicionais"),
            array("produtos_adicionais", 'through' => 'pedido_tem_produtos_adicionais', "foreign_key" => "id_pedido_tem_produto", "class_name" => "ProdutoAdicional")
	);
}

?>