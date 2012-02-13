<?

class TipoRestaurante extends ActiveRecord\Model {

    static $table_name = 'tipo_restaurante';
    static $has_many = array(
	array('restaurante_tem_tipos', 'foreign_key' => 'tipo_id', 'class_name' => 'RestauranteTemTipo'),
	array('restaurante_tem_tipos'),
	array('restaurantes', 'through' => 'restaurante_tem_tipos', 'foreign_key' => 'tipo_id', 'class_name' => 'Restaurante')
    );
    static $validates_presence_of = array(
	array('nome', 'message' => 'obrigatório')
    );
    static $validates_uniqueness_of = array(
	array('nome', 'message' => 'já existe')
    );

    public static function find_and_count_by_bairro_id($bairro_id) {
	if ($bairro_id) {
	    return self::find_by_sql('
		SELECT
		    tr.id, tr.nome, COUNT(1) AS count
		FROM
		    tipo_restaurante tr
		INNER JOIN
		    restaurante_tem_tipo rtt ON rtt.tiporestaurante_id = tr.id
		INNER JOIN
		    restaurante r ON r.id = rtt.restaurante_id
		INNER JOIN
		    restaurante_atende_bairro rab ON rab.restaurante_id = r.id
		WHERE
		    rab.bairro_id = ?
		GROUP BY
		    tr.id, tr.nome
		ORDER BY
		    tr.nome ASC
	    ', array($bairro_id));
	}
	
	return null;
    }

}

?>