<?

class PedidoTemProdutoAdicional extends ActiveRecord\Model {

    static $table_name = 'pedido_tem_produto_adicional';
    static $belongs_to = array(
	array('pedido_tem_produto'),
	array('produto_adicional')
    );
    
    static $before_save = array('copiar_preco');

    public function copiar_preco() {
        $this->preco = $this->produto_adicional->preco_adicional;
    }

}

?>