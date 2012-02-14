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
	/* o order garante que o primeiro endereço da lista é o favorito, se houver */
	array('enderecos', 'class_name' => 'EnderecoConsumidor', 'order' => 'favorito desc, id desc'),
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
    static $after_save = array('save_enderecos', 'save_telefones');
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
	if ($this->__request_attributes['hash_consumidor']) {
	    $enderecosMatrix = $_SESSION[$this->__request_attributes['hash_consumidor']];
	    $enderecoIdsInMatrix = array();
	    $enderecosPreCadastrados = $this->enderecos;

	    if (isset($enderecosMatrix)) {
		foreach ($enderecosMatrix as $enderecoArray) {
		    $endereco = new EnderecoConsumidor();

		    if ($enderecoArray['id']) {
			$enderecoIdsInMatrix[] = $enderecoArray['id'];
			$endereco = EnderecoConsumidor::find($enderecoArray['id']);
		    }

		    $endereco->set_attributes($enderecoArray);
		    $endereco->consumidor_id = $this->id;
		    $endereco->save();
		}

		/*
		 * Excluindo os endereços removidos do atributo de sessão
		 */
		if ($enderecosPreCadastrados) {
		    foreach ($enderecosPreCadastrados as $e) {
			if (!$enderecoIdsInMatrix || !in_array($e->id, $enderecoIdsInMatrix)) {
			    $e->delete();
			}
		    }
		}
	    }
	    
	    unset($_SESSION[$this->__request_attributes['hash_consumidor']]);
	}
    }
    
    public function save_telefones() {
	if ($this->__request_attributes['hash_consumidor2']) {
	    $telefonesMatrix = $_SESSION[$this->__request_attributes['hash_consumidor2']];
	    $telefoneIdsInMatrix = array();
	    $telefonesPreCadastrados = $this->telefones;

	    if (isset($telefonesMatrix)) {
		foreach ($telefonesMatrix as $telefoneArray) {
		    $telefone = new TelefoneConsumidor();

		    if ($telefoneArray['id']) {
			$telefoneIdsInMatrix[] = $telefoneArray['id'];
			$telefone = TelefoneConsumidor::find($telefoneArray['id']);
		    }

		    $telefone->set_attributes($telefoneArray);
		    $telefone->consumidor_id = $this->id;
		    $telefone->save();
		}

		/*
		 * Excluindo os telefones removidos do atributo de sessão
		 */
		if ($telefonesPreCadastrados) {
		    foreach ($telefonesPreCadastrados as $t) {
			if (!$telefoneIdsInMatrix || !in_array($t->id, $telefoneIdsInMatrix)) {
			    $t->delete();
			}
		    }
		}
	    }
	    
	    unset($_SESSION[$this->__request_attributes['hash_consumidor2']]);
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
