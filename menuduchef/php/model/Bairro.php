<?

class Bairro extends ActiveRecord\Model {

    static $table_name = 'bairro';
    static $belongs_to = array(
	array('cidade')
    );
    static $has_many = array(
	array('enderecos_de_clientes', 'class_name' => 'EnderecoConsumidor'),
	array('pedidos', 'class_name' => 'Pedido'),
	array('restaurantes_que_atendem', 'class_name' => 'RestauranteAtendeBairro'),
	array('restaurantes', 'through' => 'restaurantes_que_atendem', 'class_name' => 'Restaurante')
    );
    static $validates_presence_of = array(
	array('nome', 'message' => 'obrigatório'),
	array('cidade', 'message' => 'obrigatória')
    );
    static $validates_uniqueness_of = array(
	array(array('nome', 'Cidade' => 'cidade_id'), 'message' => 'já existem')
    );

}

?>