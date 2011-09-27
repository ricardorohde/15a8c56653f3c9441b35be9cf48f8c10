<?
require_once("php-activerecord/ActiveRecord.php");

ActiveRecord\Config::initialize(function($cfg) {

	$directoryArray = array("php/model", "../php/model", "../../php/model", "model", "../model", "../../model");

	foreach($directoryArray as $directory) {
		if(is_dir($directory)) {
			$modelDirectory = $directory;
		}
	}

	if($modelDirectory) {
		$cfg->set_model_directory($modelDirectory);

		$cfg->set_connections(array(
			'development' => 'mysql://menuduchef:menuduchef@localhost/menuduchef',
			'production' => ''
		));

		$cfg->set_default_connection('development');
	} else {
		die("O diretório das classes do modelo não é válido");
	}
});
?>