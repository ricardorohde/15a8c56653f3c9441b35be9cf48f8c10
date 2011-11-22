<?

class RestauranteTemTipoProduto extends ActiveRecord\Model {

    static $table_name = 'restaurante_tem_tipo_produto';
    static $belongs_to = array(
	array('restaurante', 'foreign_key' => 'restaurante_id'),
	array('tipo_produto', 'foreign_key' => 'tipoproduto_id')
    );
    static $validates_presence_of = array(
	array('restaurante', 'message' => 'obrigat�rio'),
	array('tipo_produto', 'message' => 'obrigat�rio')
    );
    static $validates_uniqueness_of = array(
	array(array('Restaurante' => 'restaurante_id', 'Tipo de produto' => 'tipoproduto_id'), 'message' => 'j� est�o associados')
    );

}

?>