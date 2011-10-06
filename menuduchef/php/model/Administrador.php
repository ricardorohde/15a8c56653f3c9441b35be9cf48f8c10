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
    
    public function set_senha($senha) {
	$this->assign_attribute("senha", md5($senha));
    }

}

?>