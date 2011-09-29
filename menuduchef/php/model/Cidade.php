<?

class Cidade extends ActiveRecord\Model {

	static $table_name = "cidade";

	static $has_many = array(
		array("bairros", "foreign_key" => "id_cidade", "class_name" => "Bairro"),
		array("restaurantes", "foreign_key" => "id_cidade", "class_name" => "Restaurante")
	);

	static $validates_presence_of = array(
		array('nome', 'message' => 'obrigat�rio')
	);

	static $validates_uniqueness_of = array(
		array('nome', 'message' => 'j� existe')
	);

}

?>