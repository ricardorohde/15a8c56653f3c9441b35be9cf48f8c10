<?

class UsuarioRestaurante extends ActiveRecord\Model {
    
    static $table_name = "usuario_restaurante";
    
    static $belongs_to = array(
	array("restaurante", "foreign_key" => "restaurante_id")
    );
    
    static $validates_presence_of = array(
	array("nome", "message" => "obrigatório"),
	array("restaurante", "message" => "obrigatório"),
	array("perfil", "message" => "obrigatório"),
	array("login", "message" => "obrigatório"),
	array("senha", "message" => "obrigatória")
    );
    
    static $validates_numericality_of = array(
	array("perfil", "greater_than" => 0, "message" => "obrigatório")
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

    static $PERFIL_GERENTE = 1;
    
    static $PERFIL_ATENDENTE = 2;

    public function getNomePerfil() {
	return static::getNomePerfilById($this->perfil);
    }

    public static function getNomePerfilById($id) {
	switch ($id) {
	    case static::$PERFIL_GERENTE:
		return "Gerente";

	    case static::$PERFIL_ATENDENTE:
		return "Atendente";

	    default:
		return "---";
	}
    }

}

?>