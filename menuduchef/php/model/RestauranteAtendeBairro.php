<?

class RestauranteAtendeBairro extends ActiveRecord\Model {

    static $table_name = 'restaurante_atende_bairro';
    static $belongs_to = array(
	array('restaurante'),
	array('bairro')
    );
    static $validates_uniqueness_of = array(
	array(array('Restaurante' => 'restaurante_id', 'Bairro' => 'bairro_id'), 'message' => 'já existem')
    );

}

?>