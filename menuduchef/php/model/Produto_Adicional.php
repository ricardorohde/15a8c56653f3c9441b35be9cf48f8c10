<?

class Produto_Adicional extends ActiveRecord\Model {
	static $table_name = "produto_adicional";
        static $has_many = array(
	    array("pedido_tem_produtos_adicionais", "foreign_key" => "id_produto_adicional", "class_name" => "Pedido_Tem_Produto_Adicional")
	);
}

?>