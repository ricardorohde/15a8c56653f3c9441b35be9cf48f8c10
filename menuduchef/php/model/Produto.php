<?

class Produto extends ActiveRecord\Model {

    static $table_name = "produto";
    static $belongs_to = array(
	array("restaurante", "foreign_key" => "restaurante_id")
    );
    static $has_many = array(
	array("produto_tem_pedidos", "class_name" => "PedidoTemProduto"),
	array("pedidos", "through" => "produto_tem_pedidos", "class_name" => "Pedido"),
	array("produto2_tem_pedidos", "foreign_key" => "produto2_id", "class_name" => "PedidoTemProduto"),
	array("pedidos2", "through" => "produto2_tem_pedidos", "foreign_key" => "produto2_id", "class_name" => "Pedido"),
	array("pedido_tem_produtos_adicionais", "class_name" => "PedidoTemProdutoAdicional"),
	array("produto_tem_tipos"),
	array("tipos", "through" => "produto_tem_tipos", "class_name" => "TipoProduto"),
	array("produto_tem_produtos_adicionais", "class_name" => "ProdutoTemProdutoAdicional"),
	array("produtos_adicionais", "through" => "produto_tem_produtos_adicionais", "class_name" => "ProdutoAdicional")
    );
    static $validates_presence_of = array(
	array("nome", "message" => "obrigatório"),
	array("preco", "message" => "obrigatório"),
	array("restaurante", "message" => "obrigatório")
    );
    static $validates_numericality_of = array(
	array("preco", "greater_than" => 0, "message" => "obrigatório")
    );
    static $after_save = array("save_relationships");

    public function save_relationships() {
	/*
	 * Criando objeto se ele já não existir
	 */
	
	// Tipos
	if ($this->__request_attributes["tipos"]) {
	    foreach ($this->__request_attributes["tipos"] as $id_tipo) {
		if (!$this->temTipo($id_tipo)) {
		    ProdutoTemTipo::create(array("tipoproduto_id" => $id_tipo, "produto_id" => $this->id));
		}
	    }
	}
	
	// Produtos adicionais
	if ($this->__request_attributes["produtos_adicionais"]) {
	    foreach ($this->__request_attributes["produtos_adicionais"] as $id_produto_adicional) {
		if (!$this->temProdutoAdicional($id_produto_adicional)) {
		    ProdutoTemProdutoAdicional::create(array("produtoadicional_id" => $id_produto_adicional, "produto_id" => $this->id));
		}
	    }
	}

	/*
	 * Excluindo o objeto se ele for desmarcado do formulário
	 */
	
	// Tipos
	if ($this->produto_tem_tipos) {
	    foreach ($this->produto_tem_tipos as $pt) {
		if (!$this->__request_attributes["tipos"] || !in_array($pt->tipoproduto_id, $this->__request_attributes["tipos"])) {
		    $pt->delete();
		}
	    }
	}
	
	// Produtos adicionais
	if ($this->produto_tem_produtos_adicionais) {
	    foreach ($this->produto_tem_produtos_adicionais as $ppa) {
		if (!$this->__request_attributes["produtos_adicionais"] || !in_array($ppa->produtoadicional_id, $this->__request_attributes["produtos_adicionais"])) {
		    $ppa->delete();
		}
	    }
	}
    }

    public function temTipo($id) {
	if ($this->produto_tem_tipos) {
	    foreach ($this->produto_tem_tipos as $t) {
		if ($t->tipoproduto_id == $id) {
		    return true;
		}
	    }
	}
	return false;
    }

    public function temProdutoAdicional($id) {
	if ($this->produto_tem_produtos_adicionais) {
	    foreach ($this->produto_tem_produtos_adicionais as $ppa) {
		if ($ppa->produtoadicional_id == $id) {
		    return true;
		}
	    }
	}
	return false;
    }
    
    public function getPrecoFormatado() {
	return StringUtil::doubleToCurrency($this->preco);
    }

    public function __toString() {
	return "{$this->id} | {$this->nome}";
    }

}

?>