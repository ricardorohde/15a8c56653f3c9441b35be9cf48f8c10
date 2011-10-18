<?

class Produto extends ActiveRecord\Model {
	static $table_name = "produto";
	
	static $belongs_to = array(
		array("restaurante", "foreign_key" => "restaurante_id")
	);
        
	static $has_many = array(
	    array("pedido_tem_produtos", "foreign_key" => "produto_id", "class_name" => "PedidoTemProduto"),
            array("pedidos", 'through' => 'pedido_tem_produtos', "foreign_key" => "produto_id", "class_name" => "Pedido"),
            array("pedido_tem_produtos2", "foreign_key" => "produto2_id", "class_name" => "PedidoTemProduto"),
            array("pedido_tem_produtos_adicionais", "foreign_key" => "produto_id", "class_name" => "PedidoTemProdutoAdicional"),
            array("tipos_produto", "foreign_key" => "produto_id", "class_name" => "ProdutoTemTipo"),
            
            array("produto_tem_tipos"),
            array("tipos", 'through' => 'produto_tem_tipos', "foreign_key" => "produto_id", "class_name" => "TipoProduto"),
            array("produto_tem_produtos_adicionais", "foreign_key" => "produto_id", "class_name" => "ProdutoAdicional"),
            array("produtos_adicionais", 'through' => 'produto_tem_produtos_adicionais', "foreign_key" => "produto_id", "class_name" => "ProdutoAdicional")
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