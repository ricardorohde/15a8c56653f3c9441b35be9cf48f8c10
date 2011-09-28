<?

class Restaurante extends ActiveRecord\Model {
	static $table_name = "restaurante";
	static $belongs_to = array(
		array("cidade", "foreign_key" => "id_cidade"),
                array("administrador", "foreign_key" => "id_administrador_cadastrou")
	);
        static $has_many = array(
	    array("pedidos", "foreign_key" => "id_restaurante", "class_name" => "Pedido"),
            array("produtos", "foreign_key" => "id_restaurante", "class_name" => "Produto"),
            array("bairros_atendidos", "foreign_key" => "id_restaurante", "class_name" => "Restaurante_Atende_Bairro"),
            array("tipos", "foreign_key" => "id_restaurante", "class_name" => "Tipo_Restaurante")
	);
}

?>