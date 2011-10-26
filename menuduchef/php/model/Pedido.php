<?

class Pedido extends ActiveRecord\Model {

    static $table_name = "pedido";
    static $belongs_to = array(
	array("consumidor", "foreign_key" => "consumidor_id"),
	array("restaurante", "foreign_key" => "restaurante_id")
    );
    static $has_many = array(
	array("pedido_tem_produtos", "class_name" => "PedidoTemProduto"),
	array("produtos", "through" => "pedido_tem_produtos", "class_name" => "Produto")
    );
    static $validates_presence_of = array(
	array("consumidor", "message" => "obrigatório"),
	array("forma_pagamento", "message" => "obrigatória"),
	array("restaurante", "message" => "obrigatório")
    );
    static $before_save = array("set_current_date");

    public function set_current_date() {
	$this->quando = date('Y-m-d H:i:s');
    }

}

?>