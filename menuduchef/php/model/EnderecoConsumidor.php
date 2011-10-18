<?

class EnderecoConsumidor extends ActiveRecord\Model {

    static $table_name = "endereco_consumidor";
	
    static $belongs_to = array(
	array("consumidor", "foreign_key" => "consumidor_id"),
        array("bairro", "foreign_key" => "bairro_id")
    );

}

?>