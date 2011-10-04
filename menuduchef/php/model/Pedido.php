<?

class Pedido extends ActiveRecord\Model {
	static $table_name = "pedido";
	static $belongs_to = array(
		array("consumidor", "foreign_key" => "id_consumidor"),
                array("bairro", "foreign_key" => "id_bairro"),
                array("restaurante", "foreign_key" => "id_restaurante")
	);
        static $has_many = array(
	    array("pedido_tem_produtos", "foreign_key" => "id_pedido", "class_name" => "PedidoTemProduto"),
            array("produtos", 'through' => 'pedido_tem_produtos', "foreign_key" => "id_pedido", "class_name" => "Produto")
	);
}

?>