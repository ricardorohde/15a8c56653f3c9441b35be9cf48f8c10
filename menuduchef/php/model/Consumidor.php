<?

class Consumidor extends ActiveRecord\Model {

    static $table_name = "consumidor";
    
    static $has_many = array(
	array("pedidos", "foreign_key" => "consumidor_id", "class_name" => "Pedido"),
        array("enderecos", "foreign_key" => "consumidor_id", "class_name" => "EnderecoConsumidor"),
        array("telefones", "foreign_key" => "consumidor_id", "class_name" => "TelefoneConsumidor")
    );
    
    static $validates_presence_of = array(
	array("nome", "message" => "obrigatório"),
	array("login", "message" => "obrigatório"),
	array("senha", "message" => "obrigatória")
    );
    
    static $validates_uniqueness_of = array(
	array("login", "message" => "já existe")
    );

    public function prepare_attributes(array &$attributes) {
	if ($attributes["id"] && !$attributes["modificarSenha"]) {
	    unset($attributes["senha"]);
	} else {
	    HttpUtil::validateRepeatedParameter("senha", "senha_rep", "Senha não repetida corretamente");
	}
	
	if ($attributes["senha"]) {
	    $attributes["senha"] = md5($attributes["senha"]);
	}
	
	unset($attributes["cidade_id"]);
	unset($attributes["senha_rep"]);
	unset($attributes["modificarSenha"]);
    }

}

?>