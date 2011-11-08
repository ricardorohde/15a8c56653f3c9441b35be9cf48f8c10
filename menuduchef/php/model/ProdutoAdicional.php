<?

class ProdutoAdicional extends ActiveRecord\Model {

    static $table_name = 'produto_adicional';
    static $belongs_to = array(
	array('restaurante')
    );
    static $has_many = array(
	array('produto_tem_produtos_adicionais', 'class_name' => 'ProdutoTemProdutoAdicional'),
	array('produtos', 'through' => 'produto_tem_produtos_adicionais', 'class_name' => 'Produto')
    );
    static $validates_presence_of = array(
	array('nome', 'message' => 'obrigatório'),
	array('restaurante', 'message' => 'obrigatório')
    );

}

?>