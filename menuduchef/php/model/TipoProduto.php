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
    
    /*public static function find_and_count_by_restaurante_id($restaurante_id) {
	if ($restaurante_id) {
	    return self::find_by_sql('
		SELECT
		    tp.id, tp.nome, tp.COUNT(1) AS count
		FROM
		    tipo_produto tp
		INNER JOIN
		    restaurante_tem_tipo_produto rttp ON rttp.tipoproduto_id = tp.id
		WHERE
		    rttp.restaurante_id = ?
		GROUP BY
		    tp.id, tp.nome
		ORDER BY
		    tp.nome ASC
	    ', array($restaurante_id));
	}
	
	return null;
    }*/

}

?>