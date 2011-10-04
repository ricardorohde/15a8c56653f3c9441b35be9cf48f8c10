<?

class TipoProduto extends ActiveRecord\Model {
	static $table_name = "tipo_produto";
        
        static $belongs_to = array(
		array("restaurante_tem_tipo_produto", "foreign_key" => "id_tipo")
	);
        
	static $has_many = array(
	    array("produto_tem_tipos", "foreign_key" => "id_tipo", "class_name" => "ProdutoTemTipo"),
            array("produtos", 'through' => 'produto_tem_tipos', "foreign_key" => "id_tipo", "class_name" => "Produto")
	);
}

?>