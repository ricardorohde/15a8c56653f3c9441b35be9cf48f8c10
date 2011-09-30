<?

class TipoRestaurante extends ActiveRecord\Model {
	static $table_name = "tipo_restaurante";
	static $has_many = array(
	    array("restaurante_tem_tipos", "foreign_key" => "id_tipo", "class_name" => "RestauranteTemTipo"),
            array("restaurante_tem_tipos"),
            array("restaurantes", 'through' => 'restaurante_tem_tipos', "foreign_key" => "id_tipo", "class_name" => "Restaurante")
	);
}

?>