<?

class Produto extends ActiveRecord\Model {
	static $table_name = "produto";
	static $belongs_to = array(
		array("restaurante", "foreign_key" => "id_restaurante")
	);
        static $has_many = array(
	    array("pedido_tem_produtos", "foreign_key" => "id_produto", "class_name" => "Pedido_Tem_Produto"),
            array("pedido_tem_produtos2", "foreign_key" => "id_produto2", "class_name" => "Pedido_Tem_Produto"),
            array("pedido_tem_produtos_adicionais", "foreign_key" => "id_produto", "class_name" => "Pedido_Tem_Produto_Adicional"),
            array("tipos_produto", "foreign_key" => "id_produto", "class_name" => "Produto_Tem_Tipo"),
            array("pedido_tem_produtos"),
            array("pedidos", 'through' => 'pedido_tem_produtos', "foreign_key" => "id_produto", "class_name" => "Pedido"),
            array("produto_tem_tipos"),
            array("tipos", 'through' => 'produto_tem_tipos', "foreign_key" => "id_produto", "class_name" => "Tipo_Produto"),
            array("produto_tem_produtos_adicionais"),
            array("produtos_adicionais", 'through' => 'produto_tem_produtos_adicionais', "foreign_key" => "id_produto", "class_name" => "Produto_Adicional")
	);
}

?>