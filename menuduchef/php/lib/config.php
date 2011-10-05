<?
require_once("constant.php");
require("HttpUtil.php");
require("php-activerecord/ActiveRecord.php");

/**
 * Comandos de inicializaзгo
 */
session_start();

ActiveRecord\Config::initialize(function($cfg) {

	$modelDirectoryArray = array("php/model", "../php/model", "../../php/model", "model", "../model", "../../model");

	foreach($modelDirectoryArray as $directory) {
		if(is_dir($directory)) {
			$modelDirectory = $directory;
		}
	}

	if(isset($modelDirectory)) {
		$cfg->set_model_directory($modelDirectory);

		$cfg->set_connections(array(
			"development" => "mysql://" . DATABASE_USER_DEVELOPMENT . ":". DATABASE_PASS_DEVELOPMENT ."@" . DATABASE_HOST_DEVELOPMENT ."/" . DATABASE_SCHEMA_DEVELOPMENT . "",
			"production" => "mysql://" . DATABASE_USER_PRODUCTION . ":". DATABASE_PASS_PRODUCTION ."@" . DATABASE_HOST_PRODUCTION ."/" . DATABASE_SCHEMA_PRODUCTION . ""
		));

		$cfg->set_default_connection('development');
	} else {
		die("O diretуrio das classes do modelo nгo й vбlido");
	}
});
?>