<?

class Restaurante extends ActiveRecord\Model {

    static $table_name = "restaurante";
    
    static $belongs_to = array(
	array("cidade", "foreign_key" => "cidade_id"),
	array("administrador", "foreign_key" => "administrador_cadastrou_id")
    );
    
    static $has_many = array(
	array("pedidos", "foreign_key" => "restaurante_id", "class_name" => "Pedido"),
	array("usuarios", "foreign_key" => "restaurante_id", "class_name" => "UsuarioRestaurante"),
	array("produtos", "foreign_key" => "restaurante_id", "class_name" => "Produto"),
	array("restaurante_tem_tipos", "foreign_key" => "restaurante_id", "class_name" => "RestauranteTemTipo"),
	array("bairros_atendidos", "foreign_key" => "restaurante_id", "class_name" => "RestauranteAtendeBairro"),
	array("bairros", 'through' => 'bairros_atendidos', "foreign_key" => "restaurante_id", "class_name" => "Bairro"),
	array("restaurante_tem_tipos_produto", "foreign_key" => "restaurante_id", "class_name" => "RestauranteTemTipoProduto"),
	array("tipos", 'through' => 'restaurante_tem_tipos_produto', "foreign_key" => "restaurante_id", "class_name" => "TipoRestaurante")
    );
    
    static $validates_presence_of = array(
	array("nome", "message" => "obrigat�rio"),
	array("cidade", "message" => "obrigat�ria"),
	array("endereco", "message" => "obrigat�rio"),
	array("administrador", "message" => "obrigat�rio")
    );
    
    static $validates_uniqueness_of = array(
	array(array("nome", "Cidade" => "cidade_id"), "message" => "j� existem")
    );
    
    public function atendeBairro($id) {
	if ($this->bairros_atendidos) {
	    foreach ($this->bairros_atendidos as $b) {
		if ($b->bairro_id == $id)
		    return true;
	    }
	}
	return false;
    }

}

?>