<?

class Administrador extends ActiveRecord\Model {

    static $table_name = "administrador";
    
    static $has_many = array(
	array("restaurantes_cadastrados", "foreign_key" => "administrador_cadastrou_id", "class_name" => "Restaurante")
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
	
	unset($attributes["senha_rep"]);
	unset($attributes["modificarSenha"]);
    }

}

?>