<?

class Administrador extends ActiveRecord\Model {

    static $table_name = "administrador";
    
    static $has_many = array(
	array("restaurantes_cadastrados", "foreign_key" => "administrador_cadastrou_id", "class_name" => "Restaurante")
    );
    
    static $validates_presence_of = array(
	array("nome", "message" => "obrigat�rio"),
	array("login", "message" => "obrigat�rio"),
	array("senha", "message" => "obrigat�ria")
    );
    
    static $validates_uniqueness_of = array(
	array("login", "message" => "j� existe")
    );
    
    public function prepare_attributes(array &$attributes) {
	if ($attributes["id"] && !$attributes["modificarSenha"]) {
	    unset($attributes["senha"]);
	} else {
	    HttpUtil::validateRepeatedParameter("senha", "senha_rep", "Senha n�o repetida corretamente");
	}
	
	if ($attributes["senha"]) {
	    $attributes["senha"] = md5($attributes["senha"]);
	}
	
	unset($attributes["senha_rep"]);
	unset($attributes["modificarSenha"]);
    }

}

?>