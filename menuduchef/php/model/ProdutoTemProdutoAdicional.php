<?

class ProdutoTemProdutoAdicional extends ActiveRecord\Model {
	static $table_name = "produto_tem_produto_adicional";
	static $belongs_to = array(
		array("produto", "foreign_key" => "produto_id"),
                array("produto_adicional", "foreign_key" => "produto_adicional_id")
	);
}

?>