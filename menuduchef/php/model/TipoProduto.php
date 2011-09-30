<?

class TipoProduto extends ActiveRecord\Model {
	static $table_name = "tipo_produto";
	static $has_many = array(
	    array("produto_tem_tipos", "foreign_key" => "id_tipo", "class_name" => "ProdutoTemTipo"),
            array("produto_tem_tipos"),
            array("produtos", 'through' => 'produto_tem_tipos', "foreign_key" => "id_tipo", "class_name" => "Produto")
	);
}

?>