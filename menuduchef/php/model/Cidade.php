<?

class Cidade extends ActiveRecord\Model {
	static $table_name = "cidade";
	static $has_many = array(
	    array("bairros", "foreign_key" => "id_cidade", "class_name" => "Bairro")
	);
}

?>