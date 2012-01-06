<?

class RestauranteAceitaFormaPagamento extends ActiveRecord\Model {

    static $table_name = 'restaurante_aceita_forma_pagamento';
    static $belongs_to = array(
        array('restaurante', 'class_name' => 'Restaurante'),
        array('forma_pagamento', 'class_name' => 'FormaPagamento')
    );
    
    public function __toString() {
        return $this->forma_pagamento->nome;
    }

}

?>