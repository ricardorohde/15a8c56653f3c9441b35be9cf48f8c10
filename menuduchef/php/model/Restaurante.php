<?

class Restaurante extends ActiveRecord\Model {

    static $table_name = "restaurante";
    
    static $belongs_to = array(
	array("cidade", "foreign_key" => "id_cidade"),
	array("administrador", "foreign_key" => "id_administrador_cadastrou")
    );
    
    static $has_many = array(
	array("pedidos", "foreign_key" => "id_restaurante", "class_name" => "Pedido"),
	array("usuarios", "foreign_key" => "id_restaurante", "class_name" => "UsuarioRestaurante"),
	array("produtos", "foreign_key" => "id_restaurante", "class_name" => "Produto"),
	array("restaurante_tem_tipos", "foreign_key" => "id_restaurante", "class_name" => "RestauranteTemTipo"),
	array("bairros_atendidos", "foreign_key" => "id_restaurante", "class_name" => "RestauranteAtendeBairro"),
	array("bairros", 'through' => 'bairros_atendidos', "foreign_key" => "id_restaurante", "class_name" => "Bairro"),
	array("restaurante_tem_tipos_produto", "foreign_key" => "id_restaurante", "class_name" => "RestauranteTemTipoProduto"),
	array("tipos", 'through' => 'restaurante_tem_tipos_produto', "foreign_key" => "id_restaurante", "class_name" => "TipoRestaurante")
    );
    
    static $validates_presence_of = array(
	array("nome", "message" => "obrigatório"),
	array("cidade", "message" => "obrigatória"),
	array("endereco", "message" => "obrigatório"),
	array("administrador", "message" => "obrigatório")
    );
    
    static $validates_uniqueness_of = array(
	array(array("nome", "Cidade" => "id_cidade"), "message" => "já existem")
    );

}

?>