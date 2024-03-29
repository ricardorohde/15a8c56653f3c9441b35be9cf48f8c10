<?
include_once('constant.php');
require_once('HttpUtil.php');
require_once('StringUtil.php');
require_once('php-activerecord/ActiveRecord.php');
require_once('class.upload.php');

/**
 * Inicializando o ActiveRecord
 */
ActiveRecord\Config::initialize(function($cfg) {
    $modelDirectoryArray = array('php/model', '../php/model', '../../php/model', 'model', '../model', '../../model');

    foreach ($modelDirectoryArray as $directory) {
	if (is_dir($directory)) {
	    $modelDirectory = $directory;
	}
    }

    if (isset($modelDirectory)) {
	$cfg->set_model_directory($modelDirectory);

	$cfg->set_connections(array(
	    'development' => 'mysql://' . DATABASE_USER_DEVELOPMENT . ':' . DATABASE_PASS_DEVELOPMENT . '@' . DATABASE_HOST_DEVELOPMENT . '/' . DATABASE_SCHEMA_DEVELOPMENT . '?charset=utf8',
	    'production' => 'mysql://' . DATABASE_USER_PRODUCTION . ':' . DATABASE_PASS_PRODUCTION . '@' . DATABASE_HOST_PRODUCTION . '/' . DATABASE_SCHEMA_PRODUCTION . '?charset=utf8'
	));

	$cfg->set_default_connection(HttpUtil::isLocalhost() ? 'development' : 'production');
    } else {
	die('O diret�rio das classes do modelo n�o � v�lido');
    }
});

/**
 * Inicializando a sess�o
 */
session_start();
include_once('session_vars.php');
?>