<?

class Produto_Tem_Produto_Adicional extends ActiveRecord\Model {
	static $table_name = "produto_tem_produto_adicional";
	static $belongs_to = array(
		array("produto", "foreign_key" => "id_produto"),
                array("produto_adicional", "foreign_key" => "id_produto_adicional")
	);
}

?>