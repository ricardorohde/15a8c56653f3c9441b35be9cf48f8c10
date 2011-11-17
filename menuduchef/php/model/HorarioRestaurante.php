<?

class HorarioRestaurante extends ActiveRecord\Model {

    static $table_name = 'horario_restaurante';
    static $belongs_to = array(
	array('restaurante')
    );
}

?>