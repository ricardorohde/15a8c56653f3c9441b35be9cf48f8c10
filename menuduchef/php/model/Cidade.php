<?

class Cidade extends ActiveRecord\Model {

    static $table_name = 'cidade';
    static $has_many = array(
	array('bairros', 'class_name' => 'Bairro'),
	array('restaurantes', 'class_name' => 'Restaurante')
    );
    static $validates_presence_of = array(
	array('nome', 'message' => 'obrigatório')
    );
    static $validates_uniqueness_of = array(
	array('nome', 'message' => 'já existe')
    );

}

?>