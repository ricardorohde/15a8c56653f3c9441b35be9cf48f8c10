<?

class UsuarioRestaurante extends ActiveRecord\Model implements UsuarioInterface {

    static $table_name = 'usuario_restaurante';
    static $belongs_to = array(
	array('usuario'),
	array('restaurante')
    );
    static $delegate = array(
	array('nome', 'email', 'senha', 'tipo', 'to' => 'usuario')
    );
    static $alias_attribute = array(
	'perfil' => 'tipo'
    );
    static $validates_presence_of = array(
	array('nome', 'message' => 'obrigatório'),
	array('restaurante', 'message' => 'obrigatório'),
	array('tipo', 'message' => 'obrigatório'),
	array('senha', 'message' => 'obrigatória')
    );
    static $validates_numericality_of = array(
	array('tipo', 'greater_than' => 0, 'message' => 'obrigatório')
    );
    static $validates_format_of = array(
	array('email', 'with' => '/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/', 'message' => 'inválido')
    );
    static $before_save = array('save_usuario');
    static $after_destroy = array('destroy_usuario');

    public function prepare_attributes(array &$attributes) {
	if ($attributes['id'] && !$attributes['modificarSenha']) {
	    unset($attributes['senha']);
	} else {
	    HttpUtil::validateRepeatedParameter('senha', 'senha_rep', 'Senha não repetida corretamente');
	}
    }

    public function save_usuario() {
	HttpUtil::validateRepeatedEmailUsuario($this->__request_attributes['email'], $this->usuario_id);

	if ($this->usuario->id) {
	    $usuario = $this->usuario;
	} else {
	    $usuario = new Usuario();
	}

	$usuario->tipo = $this->__request_attributes['perfil'];
	$usuario->nome = $this->__request_attributes['nome'];
	$usuario->email = $this->__request_attributes['email'];

	if ($this->__request_attributes['senha']) {
	    $usuario->senha = md5($this->__request_attributes['senha']);
	}

	$usuario->save();
	$this->usuario_id = $usuario->id;
    }

    public function destroy_usuario() {
	$this->usuario->delete();
    }

    public static function all() {
	return parent::all(array("joins" => "inner join usuario on " . static::$table_name . ".usuario_id = usuario.id", "order" => "usuario.nome asc"));
    }

}

?>