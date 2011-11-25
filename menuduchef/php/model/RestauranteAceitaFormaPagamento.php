<?

class RestauranteAceitaFormaPagamento extends ActiveRecord\Model {

    static $table_name = 'restaurante_aceita_forma_pagamento';
    static $belongs_to = array(
	array('restaurante', 'foreign_key' => 'restaurante_id'),
	array('forma_pagamento', 'foreign_key' => 'formapagamento_id')
    );
 
}

?>