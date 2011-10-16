<?

class Consumidor extends ActiveRecord\Model {

    static $table_name = "consumidor";
    
    static $belongs_to = array(
	array("bairro", "foreign_key" => "id_bairro")
    );
    
    static $has_many = array(
	array("pedidos", "foreign_key" => "id_consumidor", "class_name" => "Consumidor")
    );
    
    static $validates_presence_of = array(
	array("nome", "message" => "obrigat�rio"),
	array("endereco", "message" => "obrigat�rio"),
	array("bairro", "message" => "obrigat�rio"),
	array("telefone", "message" => "obrigat�rio"),
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
	
	unset($attributes["id_cidade"]);
	unset($attributes["senha_rep"]);
	unset($attributes["modificarSenha"]);
    }

}

?>