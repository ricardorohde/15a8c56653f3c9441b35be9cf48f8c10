<?

class EnderecoCep extends ActiveRecord\Model {

    static $table_name = 'endereco_cep';
    static $belongs_to = array(
	array('bairro')
    );
    
    public function __toString() {
	return $this->logradouro .
	    '<br />CEP: ' . StringUtil::formataCep($this->cep) .
	    '<br />' . $this->bairro . ' - ' . $this->bairro->cidade;
    }

}

?>