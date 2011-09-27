<?

class Bairro extends ActiveRecord\Model {
	static $table_name = "bairro";
	static $belongs_to = array(
		array("cidade", "foreign_key" => "id_cidade")
	);
}

?>