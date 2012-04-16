<?

class EnderecoConsumidor extends ActiveRecord\Model {

    static $table_name = 'endereco_consumidor';
    static $belongs_to = array(
	array('consumidor'),
	array('bairro')
    );
    static $has_many = array(
	array('pedidos', 'foreign_key' => 'endereco_id', 'class_name' => 'Pedido')
    );
    static $before_save = array('clean_attributes');

    public function clean_attributes() {
	$this->cep = StringUtil::onlyNumbers($this->cep);
    }

    public function hash() {
	$md5 = '';
	$to_md5 = '';
	$attributes = $this->attributes();

	if ($attributes) {
	    foreach ($attributes as $key => $attr) {
		if ($key != 'id' && $key != 'consumidor_id' && $key != 'favorito') {
		    $to_md5 .= $attr . '-';
		}
	    }

	    $md5 = md5($to_md5);
	}

	return $md5;
    }

    public function __toString() {
	return $this->logradouro . ($this->numero ? ", {$this->numero}" : '') . ($this->complemento ? ", {$this->complemento}" : '')
	    . ', ' . $this->bairro->nome . ' - ' . $this->bairro->cidade->nome . '/' . $this->bairro->cidade->uf->sigla
	    . '<br />CEP: ' . StringUtil::formataCep($this->cep);
    }

}

?>
