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

}

?>