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
	array("nome", "message" => "obrigatório"),
	array("endereco", "message" => "obrigatório"),
	array("bairro", "message" => "obrigatório"),
	array("telefone", "message" => "obrigatório"),
	array("login", "message" => "obrigatório"),
	array("senha", "message" => "obrigatória")
    );
    
    static $validates_uniqueness_of = array(
	array("login", "message" => "já existe")
    );
    
    static $before_save = array("encrypt_senha");
    
    public function encrypt_senha() {
	$this->senha = md5($this->senha);
    }

}

?>