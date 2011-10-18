<?

class ProdutoAdicional extends ActiveRecord\Model {
	static $table_name = "produto_adicional";
        
        static $belongs_to = array(
            array("restaurante", "foreign_key" => "restaurante_id")
        );
        
        static $has_many = array(
	    
            array("produto_tem_produtos_adicionais", "foreign_key" => "produto_adicional_id", "class_name" => "ProdutoTemProdutoAdicional"),
            array("produtos", 'through' => 'produto_tem_produtos_adicionais', "foreign_key" => "produto_adicional_id", "class_name" => "Produto"),
            
            array("pedido_tem_produtos_adicionais", "foreign_key" => "produto_adicional_id", "class_name" => "PedidoTemProdutoAdicional"),
            array("produtos_principais", 'through' => 'pedido_tem_produtos_adicionais', "foreign_key" => "produto_adicional_id", "class_name" => "PedidoTemProduto")
	);
}

?>