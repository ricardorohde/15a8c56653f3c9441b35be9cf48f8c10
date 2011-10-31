<?

class TipoProduto extends ActiveRecord\Model {

    static $table_name = 'tipo_produto';
    static $belongs_to = array(
	array('restaurante_tem_tipo_produto', 'foreign_key' => 'tipo_id')
    );
    static $has_many = array(
	array('produto_tem_tipos', 'foreign_key' => 'tipo_id', 'class_name' => 'ProdutoTemTipo'),
	array('produtos', 'through' => 'produto_tem_tipos', 'foreign_key' => 'tipo_id', 'class_name' => 'Produto')
    );
    static $validates_presence_of = array(
	array('nome', 'message' => 'obrigatório')
    );
    static $validates_uniqueness_of = array(
	array('nome', 'message' => 'já existe')
    );

}

?>