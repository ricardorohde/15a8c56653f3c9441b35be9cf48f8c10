<?

class EnderecoConsumidor extends ActiveRecord\Model {

    static $table_name = 'endereco_consumidor';
	
    static $belongs_to = array(
	array('consumidor'),
        array('bairro')
    );

}

?>