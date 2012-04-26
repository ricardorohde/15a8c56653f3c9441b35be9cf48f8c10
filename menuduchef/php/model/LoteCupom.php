<?

class LoteCupom extends ActiveRecord\Model {

    static $table_name = 'lote_cupom';
    static $has_many = array(
        array('cupons', 'class_name' => 'Cupom'),
        array('restaurantes_que_aceitam', 'class_name' => 'RestauranteAceitaCupom'),
        array('restaurantes', 'through' => 'restaurantes_que_aceitam', 'class_name' => 'Restaurante')
    );

    public function restauranteAceita($restaurante_id) {
	$resultado =  RestauranteAceitaCupom::find_by_lotecupom_id_and_restaurante_id($this->id, $restaurante_id);
        if($resultado){
            $resultado = 1;
        }else{
            $resultado = 0;
        }
        return $resultado;
    }
    
    static $before_save = array('set_date'); //provisorio

    public function set_date() {
	unset($this->__request_attributes['validade']);
    }
    
    static $after_save = array('save_relationships');
    public function save_relationships() {

	//Tipos
	if ($this->__request_attributes['edita_restaurantes_aceitam']) {
	    // Criando objeto se ele já não existir
	    if ($this->__request_attributes['restaurantes_aceitam']) {
		foreach ($this->__request_attributes['restaurantes_aceitam'] as $id_rest) {
		    if (!$this->restauranteAceita($id_rest)) {
			RestauranteAceitaCupom::create(array('restaurante_id' => $id_rest, 'lotecupom_id' => $this->id));
		    }
		}
	    }

	    //Excluindo o objeto se ele for desmarcado do formulário
	    if ($this->restaurantes_que_aceitam) {
		foreach ($this->restaurantes_que_aceitam as $pt) {
		    if (!$this->__request_attributes['restaurantes_aceitam'] || !in_array($pt->restaurante_id, $this->__request_attributes['restaurantes_aceitam'])) {
			$pt->delete();
		    }
		}
	    }
	}
    }
}

?>