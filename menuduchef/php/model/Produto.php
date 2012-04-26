<?

class Produto extends ActiveRecord\Model {

    static $table_name = 'produto';
    static $belongs_to = array(
	array('restaurante', 'foreign_key' => 'restaurante_id')
    );
    static $has_many = array(
	array('produto_tem_pedidos', 'class_name' => 'PedidoTemProduto'),
	array('pedidos', 'through' => 'produto_tem_pedidos', 'class_name' => 'Pedido'),
	array('produto2_tem_pedidos', 'foreign_key' => 'produto_id2', 'class_name' => 'PedidoTemProduto'),
	array('pedidos2', 'through' => 'produto2_tem_pedidos', 'foreign_key' => 'produto_id2', 'class_name' => 'Pedido'),
	array('produto3_tem_pedidos', 'foreign_key' => 'produto_id3', 'class_name' => 'PedidoTemProduto'),
	array('pedidos3', 'through' => 'produto3_tem_pedidos', 'foreign_key' => 'produto_id3', 'class_name' => 'Pedido'),
	array('produto4_tem_pedidos', 'foreign_key' => 'produto_id4', 'class_name' => 'PedidoTemProduto'),
	array('pedidos4', 'through' => 'produto4_tem_pedidos', 'foreign_key' => 'produto_id4', 'class_name' => 'Pedido'),
	array('pedido_tem_produtos_adicionais', 'class_name' => 'PedidoTemProdutoAdicional'),
	array('produto_tem_tipos'),
	array('tipos', 'through' => 'produto_tem_tipos', 'class_name' => 'TipoProduto'),
	array('produto_tem_produtos_adicionais', "foreign_key" => "produto_id", 'class_name' => 'ProdutoTemProdutoAdicional'),
	array('produtos_adicionais', 'through' => 'produto_tem_produtos_adicionais', 'class_name' => 'ProdutoAdicional')
    );
    static $validates_presence_of = array(
	array('nome', 'message' => 'obrigat�rio'),
	array('preco', 'message' => 'obrigat�rio'),
	array('restaurante', 'message' => 'obrigat�rio')
    );
    static $validates_numericality_of = array(
	array('preco', 'greater_than' => 0, 'message' => 'obrigat�rio')
    );
    static $after_save = array('save_relationships');
    var $image_x = 212;
    var $image_y = 136;

    public function getUrlImagem() {
	return PATH_IMAGE_UPLOAD . '/' . strtolower(get_class($this)) . '/' . $this->imagem;
    }

    public function save_relationships() {

	//Tipos
	if ($this->__request_attributes['edita_tipos']) {
	    // Criando objeto se ele j� n�o existir
	    if ($this->__request_attributes['tipos']) {
		foreach ($this->__request_attributes['tipos'] as $id_tipo) {
		    if (!$this->temTipo($id_tipo)) {
			ProdutoTemTipo::create(array('tipoproduto_id' => $id_tipo, 'produto_id' => $this->id));
		    }
		}
	    }

	    //Excluindo o objeto se ele for desmarcado do formul�rio
	    if ($this->produto_tem_tipos) {
		foreach ($this->produto_tem_tipos as $pt) {
		    if (!$this->__request_attributes['tipos'] || !in_array($pt->tipoproduto_id, $this->__request_attributes['tipos'])) {
			$pt->delete();
		    }
		}
	    }
	}

        if($this->__request_attributes['nao_altere_adicionais']){
            //nao acontece nada
        }else{
            //Produtos adicionais
            if ($this->__request_attributes['edita_produtos_adicionais']) {
                // Criando objeto se ele j� n�o existir
                if ($this->__request_attributes['produtos_adicionais']) {
                    foreach ($this->__request_attributes['produtos_adicionais'] as $id_produto_adicional) {
                        if (!$this->temProdutoAdicional($id_produto_adicional)) {
                            ProdutoTemProdutoAdicional::create(array('produtoadicional_id' => $id_produto_adicional, 'produto_id' => $this->id));
                        }
                    }
                }

                //Excluindo o objeto se ele for desmarcado do formul�rio
                if ($this->produto_tem_produtos_adicionais) {
                    foreach ($this->produto_tem_produtos_adicionais as $ppa) {
                        if (!$this->__request_attributes['produtos_adicionais'] || !in_array($ppa->produtoadicional_id, $this->__request_attributes['produtos_adicionais'])) {
                            $ppa->delete();
                        }
                    }
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