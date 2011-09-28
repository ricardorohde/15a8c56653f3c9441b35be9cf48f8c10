<?

class Bairro extends ActiveRecord\Model {
	static $table_name = "bairro";
	static $belongs_to = array(
		array("cidade", "foreign_key" => "id_cidade")
	);
        static $has_many = array(
	    array("consumidores", "foreign_key" => "id_bairro", "class_name" => "Consumidor"),
            array("pedidos", "foreign_key" => "id_bairro", "class_name" => "Pedido")
	);
}

?>