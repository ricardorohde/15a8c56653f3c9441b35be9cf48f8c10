<?

class RestauranteTemTipoProduto extends ActiveRecord\Model {
	static $table_name = "restaurante_tem_tipo_produto";
        
        static $belongs_to = array(
		array("restaurante", "foreign_key" => "id_restaurante"),
                array("tipo_produto", "foreign_key" => "id_tipo")
	);
}

?>