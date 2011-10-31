<?

class TelefoneConsumidor extends ActiveRecord\Model {

    static $table_name = 'telefone_consumidor';
    static $belongs_to = array(
	array('consumidor', 'foreign_key' => 'consumidor_id')
    );

}

?>