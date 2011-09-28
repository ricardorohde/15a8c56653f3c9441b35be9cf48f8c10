<?

class Consumidor extends ActiveRecord\Model {
	static $table_name = "consumidor";
	static $belongs_to = array(
		array("cidade", "foreign_key" => "id_cidade"),
                array("bairro", "foreign_key" => "id_bairro")
	);
        static $has_many = array(
	    array("pedidos", "foreign_key" => "id_consumidor", "class_name" => "Consumidor")
	);
}

?>