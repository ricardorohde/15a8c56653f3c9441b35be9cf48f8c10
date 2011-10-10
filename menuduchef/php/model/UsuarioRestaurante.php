<?

class UsuarioRestaurante extends ActiveRecord\Model {
	static $table_name = "usuario_restaurante";
	static $belongs_to = array(
		array("restaurante", "foreign_key" => "id_restaurante")
	);
        
        static $before_save = array("encrypt_senha");
    
        public function encrypt_senha() {
            $this->senha = md5($this->senha);
        }
}

?>