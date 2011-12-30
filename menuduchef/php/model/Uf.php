<?

class Uf extends ActiveRecord\Model {

    static $table_name = 'uf';
    static $has_many = array(
	array('cidades')
    );

}

?>