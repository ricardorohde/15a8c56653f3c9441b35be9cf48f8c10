<?

class Bairro extends ActiveRecord\Model {

    static $table_name = "bairro";
	
    static $belongs_to = array(
	array("cidade", "foreign_key" => "id_cidade")
    );
    
    static $has_many = array(
        array("enderecos_de_clientes", "foreign_key" => "id_bairro", "class_name" => "EnderecoConsumidor"),
	array("pedidos", "foreign_key" => "id_bairro", "class_name" => "Pedido"),
	array("restaurantes_que_atendem", "foreign_key" => "id_bairro", "class_name" => "RestauranteAtendeBairro"),
	array("restaurantes", "through" => "restaurantes_que_atendem", "foreign_key" => "id_bairro", "class_name" => "Restaurante")
    );
    
    static $validates_presence_of = array(
	array("nome", "message" => "obrigat�rio"),
	array("cidade", "message" => "obrigat�ria")
    );
    
    static $validates_uniqueness_of = array(
	array(array("nome", "Cidade" => "id_cidade"), "message" => "j� existem")
    );

}

?>