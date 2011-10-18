<?

class RestauranteAtendeBairro extends ActiveRecord\Model {

	static $table_name = "restaurante_atende_bairro";
	static $belongs_to = array(
		array("restaurante", "foreign_key" => "restaurante_id"),
		array("bairro", "foreign_key" => "bairro_id")
	);

}

?>