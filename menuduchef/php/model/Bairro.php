<?

class Bairro extends ActiveRecord\Model {

    static $table_name = "bairro";
	
    static $belongs_to = array(
	array("cidade", "foreign_key" => "id_cidade")
    );
    
    static $has_many = array(
	array("consumidores", "foreign_key" => "id_bairro", "class_name" => "Consumidor"),
	array("pedidos", "foreign_key" => "id_bairro", "class_name" => "Pedido"),
	array("restaurantes_que_atendem", "foreign_key" => "id_bairro", "class_name" => "RestauranteAtendeBairro"),
	array("restaurantes", "through" => "restaurantes_que_atendem", "foreign_key" => "id_bairro", "class_name" => "Restaurante")
    );
    
    static $validates_presence_of = array(
	array("nome", "message" => "obrigatório"),
	array("cidade", "message" => "obrigatória")
    );
    
    static $validates_uniqueness_of = array(
	array(array("nome", "Cidade" => "id_cidade"), "message" => "já existem")
    );

}

?>