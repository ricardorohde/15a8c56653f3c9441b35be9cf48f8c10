<?

class TelefoneConsumidor extends ActiveRecord\Model {

    static $table_name = 'telefone_consumidor';
    static $belongs_to = array(
	array('consumidor', 'foreign_key' => 'consumidor_id')
    );
    
    public function hash() {
	$md5 = '';
	$to_md5 = '';
	$attributes = $this->attributes();

	if ($attributes) {
	    foreach ($attributes as $key => $attr) {
		if ($key != 'id' && $key != 'consumidor_id') {
		    $to_md5 .= $attr . '-';
		}
	    }
	    
	    $md5 = md5($to_md5);
	}

	return $md5;
    }

    public function __toString() {
	return $this->numero;
    }

}

?>