<?

class RestauranteTemTipo extends ActiveRecord\Model {
	static $table_name = "restaurante_tem_tipo";
	static $belongs_to = array(
		array("restaurante", "foreign_key" => "id_restaurante"),
                array("tipo_restaurante", "foreign_key" => "id_tipo")
	);
}

?>