<?

class EnderecoConsumidor extends ActiveRecord\Model {

    static $table_name = "endereco_consumidor";
	
    static $belongs_to = array(
	array("consumidor", "foreign_key" => "id_consumidor"),
        array("bairro", "foreign_key" => "id_bairro")
    );

}

?>