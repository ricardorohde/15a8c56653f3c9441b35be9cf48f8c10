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

    public static function all($paramOptions = null) {
	$options = array('order' => 'nome asc', 'conditions' => array('ativa' => 1));
	
	if($paramOptions) {
	    $options = array_merge($options, $paramOptions);
	}
	
	return parent::all($options);
    }

}

?>