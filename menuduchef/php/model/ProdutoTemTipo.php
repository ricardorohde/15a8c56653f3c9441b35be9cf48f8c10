<?

class ProdutoTemTipo extends ActiveRecord\Model {
	static $table_name = "produto_tem_tipo";
	static $belongs_to = array(
		array("tipo_produto", "foreign_key" => "id_tipo"),
                array("produto", "foreign_key" => "id_produto")
	);
}

?>