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
    static $before_create = array('set_current_date');
    static $before_save = array('set_preco_entrega');

    public function set_current_date() {
	$this->quando = date('Y-m-d H:i:s');
    }
    public function set_preco_entrega() {
        $bairro = $this->endereco_consumidor->bairro_id;
        $taxa = RestauranteAtendeBairro::find(array("conditions" => array("restaurante_id = ? AND bairro_id = ?",$this->restaurante_id,$bairro)));
	$this->preco_entrega = $taxa->preco_entrega;
    }

}

?>
