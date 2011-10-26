<?

include_once("../lib/config.php");

$data = HttpUtil::getParameterArray();
$redirect = isset ($redirect) ? $redirect : true;

$obj = new $class();

if ($data) {
    $deleteId = array_key_exists("deleteId", $data) ? $data["deleteId"] : 0;
    $id = array_key_exists("id", $data) ? $data["id"] : $deleteId;

    if ($id) {
	$obj = $class::find($id);
    }

    if ($deleteId) {
	try {
	    $obj->delete();
	    HttpUtil::showInfoMessages(array("Exclus�o realizada com sucesso"));
	} catch (Exception $e) {
	    HttpUtil::showErrorMessages(array("N�o foi poss�vel realizar a exclus�o: h� dados associados a este registro"));
	}
    } else {
	$obj->set_attributes($data);
	$obj->save();

	if ($obj->is_valid() && $obj->errors->is_empty()) {
	    if ($id) {
		HttpUtil::showInfoMessages(array("Modifica��o realizada com sucesso"));
	    } else {
		HttpUtil::showInfoMessages(array("Cadastro realizado com sucesso"));
	    }
	} else {
	    $_SESSION["obj"] = $data;
	    HttpUtil::showErrorMessages($obj->errors->full_messages());
	    HttpUtil::redirect("form/" . ($obj->id ? : ""));
	}
    }

    if ($redirect) {
	HttpUtil::redirect("./");
    }
}
?>