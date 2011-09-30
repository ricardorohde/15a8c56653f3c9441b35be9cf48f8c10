<?

class TipoProduto extends ActiveRecord\Model {
	static $table_name = "tipo_produto";
        static $belongs_to = array(
		array("restaurante", "foreign_key" => "id_restaurante")
	);
        
	static $has_many = array(
	    array("produto_tem_tipos", "foreign_key" => "id_tipo", "class_name" => "ProdutoTemTipo"),
            array("produto_tem_tipos"),
            array("produtos", 'through' => 'produto_tem_tipos', "foreign_key" => "id_tipo", "class_name" => "Produto")
	);
}

?>