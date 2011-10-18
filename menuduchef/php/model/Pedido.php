<?

class Pedido extends ActiveRecord\Model {
	static $table_name = "pedido";
	static $belongs_to = array(
		array("consumidor", "foreign_key" => "consumidor_id"),
                array("bairro", "foreign_key" => "bairro_id"),
                array("restaurante", "foreign_key" => "restaurante_id")
	);
        static $has_many = array(
	    array("pedido_tem_produtos", "foreign_key" => "pedido_id", "class_name" => "PedidoTemProduto"),
            array("produtos", 'through' => 'pedido_tem_produtos', "foreign_key" => "pedido_id", "class_name" => "Produto")
	);
        
        static $before_save = array("set_current_date");

        public function set_current_date() {
        $this->quando = date('Y-m-d H:i:s');
}
}

?>