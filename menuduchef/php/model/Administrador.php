<?

class Administrador extends ActiveRecord\Model {
	static $table_name = "administrador";
        static $has_many = array(
	    array("restaurantes_cadastrados", "foreign_key" => "id_administrador_cadastrou", "class_name" => "Restaurante")
	);
}

?>