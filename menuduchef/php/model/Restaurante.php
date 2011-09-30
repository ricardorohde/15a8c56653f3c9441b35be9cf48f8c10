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
            array("restaurante_tem_tipos", "foreign_key" => "id_restaurante", "class_name" => "RestauranteTemTipo"),
            array("bairros_atendidos", "foreign_key" => "id_restaurante", "class_name" => "RestauranteAtendeBairro"),
            array("bairros", 'through' => 'bairros_atendidos', "foreign_key" => "id_restaurante", "class_name" => "Bairro"),
            array("restaurante_tem_tipos"),
            array("tipos", 'through' => 'restaurante_tem_tipos', "foreign_key" => "id_restaurante", "class_name" => "TipoRestaurante")
	);
}

?>