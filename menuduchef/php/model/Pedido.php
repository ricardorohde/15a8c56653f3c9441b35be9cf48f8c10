<?

class Pedido extends ActiveRecord\Model {

    static $table_name = 'pedido';
    static $belongs_to = array(
	array('consumidor'),
	array('restaurante'),
        array('endereco_consumidor', 'foreign_key' => 'endereco_id')
    );
    static $has_many = array(
	array('pedido_tem_produtos', 'class_name' => 'PedidoTemProduto'),
	array('produtos', 'through' => 'pedido_tem_produtos', 'class_name' => 'Produto')
    );
    static $validates_presence_of = array(
	array('consumidor', 'message' => 'obrigatório'),
	array('restaurante', 'message' => 'obrigatório'),
	array('endereco_consumidor', 'message' => 'obrigatório'),
	array('forma_pagamento', 'message' => 'obrigatória')
    );
    static $before_save = array('set_current_date');

    public function set_current_date() {
	$this->quando = date('Y-m-d H:i:s');
    }

}

?>