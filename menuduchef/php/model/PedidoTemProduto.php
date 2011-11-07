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
        if($this->produto->esta_em_promocao){
            $preco = $this->produto->preco_promocional;
        }else{
            $preco = $this->produto->preco;
        }
        
        if($this->produto2->preco){
            if($this->produto2->esta_em_promocao){
                $pcomp = $this->produto2->preco_promocional;
            }else{
                $pcomp = $this->produto2->preco;
            }
            $preco = max($preco,$pcomp);
        }
        if($this->produto3->preco){
            if($this->produto3->esta_em_promocao){
                $pcomp = $this->produto3->preco_promocional;
            }else{
                $pcomp = $this->produto3->preco;
            }
            $preco = max($preco,$pcomp);
        }
        if($this->produto4->preco){
            if($this->produto4->esta_em_promocao){
                $pcomp = $this->produto4->preco_promocional;
            }else{
                $pcomp = $this->produto4->preco;
            }
            $preco = max($preco,$pcomp);
        }
	$this->preco_unitario = $preco;
    }

}

?>