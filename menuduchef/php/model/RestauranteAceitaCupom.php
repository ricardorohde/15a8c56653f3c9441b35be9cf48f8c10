<?

class RestauranteAceitaCupom extends ActiveRecord\Model {

    static $table_name = 'restaurante_aceita_cupom';
    static $belongs_to = array(
        array('restaurante'),
        array('lote_cupom', 'foreign_key' => 'lotecupom_id')
    );
}

?>