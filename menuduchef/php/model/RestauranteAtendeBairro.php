<?

class RestauranteAtendeBairro extends ActiveRecord\Model {

	static $table_name = "restaurante_atende_bairro";
	static $belongs_to = array(
		array("restaurante", "foreign_key" => "id_restaurante"),
		array("bairro", "foreign_key" => "id_bairro")
	);

}

?>