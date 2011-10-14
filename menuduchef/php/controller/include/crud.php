<?

include_once("../lib/config.php");

$data = HttpUtil::getParameterArray();

$obj = new $class();

if ($data) {
    $deleteId = array_key_exists("deleteId", $data) ? $data["deleteId"] : 0;
    $id = array_key_exists("id", $data) ? $data["id"] : $deleteId;

    if ($id) {
	$obj = $class::find($id);
    }

    if ($deleteId) {
	$obj->delete();
	HttpUtil::showInfoMessages(array("Exclusão realizada com sucesso"));
    } else {
	$obj->set_attributes($data);
	$obj->save();

	if ($obj->is_valid()) {
	    if ($id) {
		HttpUtil::showInfoMessages(array("Modificação realizada com sucesso"));
	    } else {
		HttpUtil::showInfoMessages(array("Cadastro realizado com sucesso"));
	    }
	} else {
	    $_SESSION["obj"] = $data;
	    HttpUtil::showErrorMessages($obj->errors->full_messages());
	    header("Location: form/" . ($obj->id ? : ""));
	}
    }

    if ($obj->is_valid()) {
	header("Location: ./");
    }
}
?>