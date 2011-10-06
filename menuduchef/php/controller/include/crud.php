<?
include_once("../lib/config.php");

$data = HttpUtil::getParameterArray();

$obj = new $class();

if ($data) {
    $id = array_key_exists("id", $data) ? $data["id"] : 0;
    $action = array_key_exists("action", $data) ? $data["action"] : 0;
    unset($data["action"]);

    if ($id) {
	$obj = $class::find($id);
    }

    if ($action) {
	switch ($action) {
	    case "create":
		$obj = new $class($data);
		$obj->save();
		
		if ($obj->is_valid()) {
		    HttpUtil::showInfoMessages(array("Cadastro realizado com sucesso"));
		}
		
		break;

	    case "update":
		$obj->update_attributes($data);
		
		if ($obj->is_valid()) {
		    HttpUtil::showInfoMessages(array("Modificação realizada com sucesso"));
		}
		
		break;

	    case "delete":
		$obj->delete();
		HttpUtil::showInfoMessages(array("Exclusão realizada com sucesso"));
		break;

	    default:
		break;
	}
    }
}

if ($obj->is_invalid()) {
    HttpUtil::showErrorMessages($obj->errors->full_messages());
    header("Location: form/" . ($obj->id ?: ""));
} else {
    header("Location: list");
}
?>