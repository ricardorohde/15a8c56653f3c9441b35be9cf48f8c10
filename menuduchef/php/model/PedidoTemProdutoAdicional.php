<?

class PedidoTemProdutoAdicional extends ActiveRecord\Model {
	static $table_name = "pedido_tem_produto_adicional";
	static $belongs_to = array(
		array("pedido_tem_produto", "foreign_key" => "pedido_tem_produto_id"),
                array("produto_adicional", "foreign_key" => "produto_adicional_id")
	);
}

?>