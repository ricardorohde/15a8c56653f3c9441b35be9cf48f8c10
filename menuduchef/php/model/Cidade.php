<?

class Cidade extends ActiveRecord\Model {

    static $table_name = 'cidade';
    static $belongs_to = array(
	array('uf')
    );
    static $has_many = array(
	array('bairros'),
	array('restaurantes')
    );
    static $validates_presence_of = array(
	array('nome', 'message' => 'obrigatório')
    );
    
    public function __toString() {
	return "{$this->nome} - {$this->uf->sigla}";
    }

    public static function all() {
	return parent::all(array('order' => 'nome asc', 'conditions' => array('ativa' => 1)));
    }

}

?>