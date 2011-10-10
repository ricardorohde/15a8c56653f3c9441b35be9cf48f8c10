<?

class ProdutoAdicional extends ActiveRecord\Model {
	static $table_name = "produto_adicional";
        static $has_many = array(
	    array("pedido_tem_produtos_adicionais", "foreign_key" => "id_produto_adicional", "class_name" => "PedidoTemProdutoAdicional"),
            array("produto_tem_produtos_adicionais"),
            array("produtos", 'through' => 'produto_tem_produtos_adicionais', "foreign_key" => "id_produto_adicional", "class_name" => "Produto"),
            array("pedido_tem_produtos_adicionais"),
            array("produtos_principais", 'through' => 'pedido_tem_produtos_adicionais', "foreign_key" => "id_produto_adicional", "class_name" => "PedidoTemProduto")
	);
}

?>