<?

class FormaPagamento extends ActiveRecord\Model {

    static $table_name = 'forma_pagamento';

    public function __toString() {
        return $this->nome;
    }

}

?>