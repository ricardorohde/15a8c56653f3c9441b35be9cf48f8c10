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
            array("tipos", "foreign_key" => "id_produto", "class_name" => "Tipo_Produto")
	);
}

?>