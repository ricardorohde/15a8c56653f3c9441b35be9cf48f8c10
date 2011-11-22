<?

class ProdutoTemProdutoAdicional extends ActiveRecord\Model {

    static $table_name = 'produto_tem_produto_adicional';
    static $belongs_to = array(
	array('produto'),
	array('produto_adicional')
    );
    static $validates_presence_of = array(
	array('produto', 'message' => 'obrigatório'),
	array('produto_adicional', 'message' => 'obrigatório')
    );

}

?>