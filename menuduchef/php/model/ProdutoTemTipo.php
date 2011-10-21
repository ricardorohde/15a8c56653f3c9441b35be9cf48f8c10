<?

class ProdutoTemTipo extends ActiveRecord\Model {

    static $table_name = "produto_tem_tipo";
    static $belongs_to = array(
	array("tipo_produto"),
	array("produto")
    );

}

?>