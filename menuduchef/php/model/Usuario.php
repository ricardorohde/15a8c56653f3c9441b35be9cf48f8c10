<?

class Usuario extends ActiveRecord\Model {

    static $table_name = 'usuario';
    static $ADMINISTRADOR = 1;
    static $GERENTE = 2;
    static $ATENDENTE = 3;
    static $CONSUMIDOR = 4;
    
    public static function emailExiste($email, $excludeId) {
	if ($excludeId) {
	    $conditions = array('id <> ? and email = ?', $excludeId, $email);
	} else {
	    $conditions = array('email = ?', $email);
	}
	return self::exists(array('conditions' => $conditions));
    }

    public function getNomePerfil() {
	return static::getNomePerfilById($this->tipo);
    }

    public static function getNomePerfilById($id) {
	switch ($id) {
	    case static::$ADMINISTRADOR:
		return 'Administrador';

	    case static::$GERENTE:
		return 'Gerente';

	    case static::$ATENDENTE:
		return 'Atendente';

	    case static::$CONSUMIDOR:
		return 'Cliente';

	    default:
		return '---';
	}
    }
    
    public static function login($email, $input_senha) {
	return static::find_by_email_and_senha($email, md5($input_senha));
    }

}

?>