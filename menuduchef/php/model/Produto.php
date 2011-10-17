<?

class Produto extends ActiveRecord\Model {
	static $table_name = "produto";
	
	static $belongs_to = array(
		array("restaurante", "foreign_key" => "id_restaurante")
	);
        
	static $has_many = array(
	    array("pedido_tem_produtos", "foreign_key" => "id_produto", "class_name" => "PedidoTemProduto"),
            array("pedidos", 'through' => 'pedido_tem_produtos', "foreign_key" => "id_produto", "class_name" => "Pedido"),
            array("pedido_tem_produtos2", "foreign_key" => "id_produto2", "class_name" => "PedidoTemProduto"),
            array("pedido_tem_produtos_adicionais", "foreign_key" => "id_produto", "class_name" => "PedidoTemProdutoAdicional"),
            array("tipos_produto", "foreign_key" => "id_produto", "class_name" => "ProdutoTemTipo"),
            
            array("produto_tem_tipos"),
            array("tipos", 'through' => 'produto_tem_tipos', "foreign_key" => "id_produto", "class_name" => "TipoProduto"),
            array("produto_tem_produtos_adicionais", "foreign_key" => "id_produto", "class_name" => "ProdutoAdicional"),
            array("produtos_adicionais", 'through' => 'produto_tem_produtos_adicionais', "foreign_key" => "id_produto", "class_name" => "ProdutoAdicional")
	);
	
	static $validates_presence_of = array(
	    array("nome", "message" => "obrigatório"),
	    array("preco", "message" => "obrigatório"),
	    array("restaurante", "message" => "obrigatório")
	);
	
	static $validates_numericality_of = array(
	    array("preco", "greater_than" => 0, "message" => "obrigatório")
	);
	
	public function getPrecoFormatado() {
	    return StringUtil::doubleToCurrency($this->preco);
	}
	
}

?>