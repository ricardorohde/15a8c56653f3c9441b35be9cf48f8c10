<?

class Consumidor extends ActiveRecord\Model implements UsuarioInterface {

    static $table_name = 'consumidor';
    static $belongs_to = array(
	array('usuario')
    );
    static $delegate = array(
	array('nome', 'email', 'senha', 'to' => 'usuario')
    );
    static $has_many = array(
	array('pedidos', 'class_name' => 'Pedido'),
	array('enderecos', 'class_name' => 'EnderecoConsumidor'),
	array('telefones', 'class_name' => 'TelefoneConsumidor')
    );
    static $validates_presence_of = array(
	array('nome', 'message' => 'obrigatório'),
	array('cpf', 'message' => 'obrigatório'),
	array('data_nascimento', 'message' => 'obrigatória'),
	array('senha', 'message' => 'obrigatória')
    );
    static $validates_uniqueness_of = array(
	array('cpf', 'message' => 'já utilizado por outro cliente')
    );
    static $validates_format_of = array(
	array('email', 'with' => '/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/', 'message' => 'inválido')
    );
    static $before_save = array('save_usuario');
    static $after_save = array('save_enderecos');
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

	$usuario->tipo = Usuario::$CONSUMIDOR;
	$usuario->nome = $this->__request_attributes['nome'];
	$usuario->email = $this->__request_attributes['email'];

	if ($this->__request_attributes['senha']) {
	    $usuario->senha = md5($this->__request_attributes['senha']);
	}

	$usuario->save();
	$this->usuario_id = $usuario->id;
    }
    
    public function save_enderecos() {
	if($this->__request_attributes['hash']) {
	    $enderecosMatrix = $_SESSION[$this->__request_attributes['hash']];
	    
	    if($enderecosMatrix) {
		foreach($enderecosMatrix as $enderecoArray) {
		    $endereco = new EnderecoConsumidor($enderecoArray);
		    $endereco->consumidor_id = $this->id;
		    $endereco->save();
		}
	    }
	    
	    unset($_SESSION[$this->__request_attributes['hash']]);
	}
    }

    public function destroy_usuario() {
	$this->usuario->delete();
    }
    
    public static function all() {
	return parent::all(array("joins" => "inner join usuario on " . static::$table_name . ".usuario_id = usuario.id", "order" => "usuario.nome asc"));
    }

}

?>