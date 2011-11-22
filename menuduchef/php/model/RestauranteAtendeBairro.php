<?

class RestauranteAtendeBairro extends ActiveRecord\Model {

    static $table_name = 'restaurante_atende_bairro';
    static $belongs_to = array(
	array('restaurante'),
	array('bairro')
    );
    static $validates_presence_of = array(
	array('restaurante', 'message' => 'obrigatório'),
	array('bairro', 'message' => 'obrigatório'),
	array('preco_entrega', 'message' => 'obrigatório')
    );
    static $validates_uniqueness_of = array(
	array(array('Restaurante' => 'restaurante_id', 'Bairro' => 'bairro_id'), 'message' => 'já estão associados')
    );
    
    public function getPrecoFormatado() {
	return StringUtil::doubleToCurrency($this->preco_entrega);
    }

}

?>