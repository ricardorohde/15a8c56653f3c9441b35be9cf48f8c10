<?

class UsuarioRestaurante extends ActiveRecord\Model {
	static $table_name = "usuario_restaurante";
	static $belongs_to = array(
		array("restaurante", "foreign_key" => "id_restaurante")
	);
}

?>