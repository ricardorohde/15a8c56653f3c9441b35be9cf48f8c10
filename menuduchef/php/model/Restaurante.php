<?

class Restaurante extends ActiveRecord\Model {

    static $table_name = 'restaurante';
    static $belongs_to = array(
	array('cidade'),
	array('administrador', 'foreign_key' => 'administrador_cadastrou_id')
    );
    static $has_many = array(
	array('pedidos', 'class_name' => 'Pedido'),
	array('usuarios', 'class_name' => 'UsuarioRestaurante'),
	array('produtos', 'class_name' => 'Produto'),
	array('restaurante_tem_tipos', 'class_name' => 'RestauranteTemTipo'),
	array('bairros_atendidos', 'class_name' => 'RestauranteAtendeBairro'),
	array('bairros', 'through' => 'bairros_atendidos', 'class_name' => 'Bairro'),
	array('restaurante_tem_tipos_produto', 'class_name' => 'RestauranteTemTipoProduto'),
	array('tipos', 'through' => 'restaurante_tem_tipos_produto', 'class_name' => 'TipoRestaurante')
    );
    static $validates_presence_of = array(
	array('nome', 'message' => 'obrigatório'),
	array('cidade', 'message' => 'obrigatória'),
	array('endereco', 'message' => 'obrigatório'),
	array('administrador', 'message' => 'obrigatório')
    );
    static $validates_uniqueness_of = array(
	array(array('nome', 'Cidade' => 'cidade_id'), 'message' => 'já existem')
    );
    static $after_save = array('save_tipos', 'save_tipos_de_produto', 'save_bairros_atendidos');

    public function save_tipos() {
	/*
	 * Criando objeto se ele já não existir
	 */
	if ($this->__request_attributes['tipos']) {
	    foreach ($this->__request_attributes['tipos'] as $id_tipo) {
		if (!$this->temTipo($id_tipo)) {
		    RestauranteTemTipo::create(array('tiporestaurante_id' => $id_tipo, 'restaurante_id' => $this->id));
		}
	    }
	}

	/*
	 * Excluindo o objeto se ele for desmarcado do formulário
	 */
	if ($this->restaurante_tem_tipos) {
	    foreach ($this->restaurante_tem_tipos as $rt) {
		if (!$this->__request_attributes['tipos'] || !in_array($rt->tiporestaurante_id, $this->__request_attributes['tipos'])) {
		    $rt->delete();
		}
	    }
	}
    }

    public function save_tipos_de_produto() {
	/*
	 * Criando objeto se ele já não existir
	 */
	if ($this->__request_attributes['tipos_produto']) {
	    foreach ($this->__request_attributes['tipos_produto'] as $id_tipo) {
		if (!$this->temTipoProduto($id_tipo)) {
		    RestauranteTemTipoProduto::create(array('tipoproduto_id' => $id_tipo, 'restaurante_id' => $this->id));
		}
	    }
	}

	/*
	 * Excluindo o objeto se ele for desmarcado do formulário
	 */
	if ($this->restaurante_tem_tipos_produto) {
	    foreach ($this->restaurante_tem_tipos_produto as $rt) {
		if (!$this->__request_attributes['tipos_produto'] || !in_array($rt->tipoproduto_id, $this->__request_attributes['tipos_produto'])) {
		    $rt->delete();
		}
	    }
	}
    }

    public function save_bairros_atendidos() {
	/*
	 * Criando objeto se ele já não existir
	 */
	if ($this->__request_attributes['bairros']) {
	    foreach ($this->__request_attributes['bairros'] as $index => $id_bairro) {
		$preco_entrega = $this->__request_attributes['preco_entrega'][$index];
		if (!$this->atendeBairro($id_bairro)) {
		    RestauranteAtendeBairro::create(array('bairro_id' => $id_bairro, 'restaurante_id' => $this->id, 'preco_entrega' => $preco_entrega));
		}
	    }
	}

	/*
	 * Excluindo o objeto se ele for desmarcado do formulário
	 */
	if ($this->bairros_atendidos) {
	    foreach ($this->bairros_atendidos as $ba) {
		if (!$this->__request_attributes['bairros'] || !in_array($ba->bairro_id, $this->__request_attributes['bairros'])) {
		    $ba->delete();
		}
	    }
	}
    }

    public function atendeBairro($id) {
	if ($this->bairros_atendidos) {
	    foreach ($this->bairros_atendidos as $b) {
		if ($b->bairro_id == $id)
		    return true;
	    }
	}
	return false;
    }

    public function temTipo($id) {
	if ($this->restaurante_tem_tipos) {
	    foreach ($this->restaurante_tem_tipos as $t) {
		if ($t->tiporestaurante_id == $id)
		    return true;
	    }
	}
	return false;
    }

    public function temTipoProduto($id) {
	if ($this->restaurante_tem_tipos_produto) {
	    foreach ($this->restaurante_tem_tipos_produto as $t) {
		if ($t->tipoproduto_id == $id)
		    return true;
	    }
	}
	return false;
    }
    
    public function getNomeCategoria() {
        if($this->categoria_personalizada) {
            return $this->categoria_personalizada;
        } else {
            $cats = RestauranteTemTipo::find_by_sql("SELECT TR.* FROM restaurante_tem_tipo RTT INNER JOIN tipo_restaurante TR ON RTT.tiporestaurante_id = TR.id WHERE RTT.restaurante_id = ".$this->id." ORDER BY TR.nome desc");
            if($cats){
                if(sizeof($cats)==1){
                    foreach($cats as $cat){
                        $categorias = $cat->nome;
                    }
                }else{
                    $pri = 1;
                    $tam = sizeof($cats);
                    foreach($cats as $cat){
                        if($pri){
                            $categorias = " e ".$cat->nome;
                            $pri = 0;
                        }else if($tam==1){
                            $categorias = $cat->nome.$categorias;
                        }else{
                            $categorias = ", ".$cat->nome.$categorias;
                        }
                        $tam--;
                    }
                }
            }
            return $categorias;
        }
    }

}

?>