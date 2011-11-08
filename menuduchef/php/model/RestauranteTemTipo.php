<?

class RestauranteTemTipo extends ActiveRecord\Model {

    static $table_name = 'restaurante_tem_tipo';
    static $belongs_to = array(
	array('restaurante', 'foreign_key' => 'restaurante_id'),
	array('tipo_restaurante', 'foreign_key' => 'tiporestaurante_id')
    );
    static $validates_presence_of = array(
	array('restaurante', 'message' => 'obrigat�rio'),
	array('tipo_restaurante', 'message' => 'obrigat�rio')
    );
    static $validates_uniqueness_of = array(
	array(array('Restaurante' => 'restaurante_id', 'Tipo de restaurante' => 'tiporestaurante_id'), 'message' => 'j� est�o associados')
    );

}

?>