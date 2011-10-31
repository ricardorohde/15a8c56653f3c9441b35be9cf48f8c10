<?

class PedidoTemProduto extends ActiveRecord\Model {

    static $table_name = 'pedido_tem_produto';
    static $belongs_to = array(
	array('pedido'),
	array('produto'),
	array('produto2', 'foreign_key' => 'produto_id2', 'class_name' => 'Produto'),
	array('produto3', 'foreign_key' => 'produto_id3', 'class_name' => 'Produto'),
	array('produto4', 'foreign_key' => 'produto_id4', 'class_name' => 'Produto')
    );
    static $has_many = array(
	array('pedido_tem_produtos_adicionais', 'class_name' => 'PedidoTemProdutoAdicional'),
	array('produtos_adicionais', 'through' => 'pedido_tem_produtos_adicionais', 'class_name' => 'ProdutoAdicional')
    );
    static $before_create = array('copiar_preco');

    public function copiar_preco() {
	$this->preco_unitario = $this->produto->preco;
    }

}

?>