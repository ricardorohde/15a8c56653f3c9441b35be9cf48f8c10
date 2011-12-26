<?

class EnderecoCep extends ActiveRecord\Model {

    static $table_name = 'endereco_cep';
    static $belongs_to = array(
	array('bairro')
    );

}

?>