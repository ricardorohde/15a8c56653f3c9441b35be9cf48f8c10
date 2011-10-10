<?

class Administrador extends ActiveRecord\Model {

    static $table_name = "administrador";
    
    static $has_many = array(
	array("restaurantes_cadastrados", "foreign_key" => "id_administrador_cadastrou", "class_name" => "Restaurante")
    );
    
    static $validates_presence_of = array(
	array("nome", "message" => "obrigat�rio"),
	array("login", "message" => "obrigat�rio"),
	array("senha", "message" => "obrigat�ria")
    );
    
    static $validates_uniqueness_of = array(
	array("login", "message" => "j� existe")
    );
    
    static $before_save = array("encrypt_senha");
    
    public function encrypt_senha() {
	$this->senha = md5($this->senha);
    }

}

?>