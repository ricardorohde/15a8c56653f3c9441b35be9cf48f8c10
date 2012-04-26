<?

class Cupom extends ActiveRecord\Model {

    static $table_name = 'cupom';
    static $belongs_to = array(
        array('pedido'),
        array('lote_cupom', 'foreign_key' => 'lotecupom_id'),
        array('administrador')
    );
}

?>