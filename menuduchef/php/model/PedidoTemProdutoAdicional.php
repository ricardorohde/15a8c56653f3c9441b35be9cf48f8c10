<?

class Pedido_Tem_Produto_Adicional extends ActiveRecord\Model {
	static $table_name = "pedido_tem_produto_adicional";
	static $belongs_to = array(
		array("pedido_tem_produto", "foreign_key" => "id_pedido_tem_produto"),
                array("produto_adicional", "foreign_key" => "id_produto_adicional")
	);
}

?>