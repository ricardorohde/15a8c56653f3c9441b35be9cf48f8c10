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
	try {
	    $obj->delete();
	    HttpUtil::showInfoMessages(array("Exclusгo realizada com sucesso"));
	} catch(Exception $e) {
	    HttpUtil::showErrorMessages(array("Nгo foi possнvel realizar a exclusгo: hб dados associados a este registro"));
	}
    } else {
	$obj->set_attributes($data);
	$obj->save();

	if ($obj->is_valid()) {
	    if ($id) {
		HttpUtil::showInfoMessages(array("Modificaзгo realizada com sucesso"));
	    } else {
		HttpUtil::showInfoMessages(array("Cadastro realizado com sucesso"));
	    }
	} else {
	    $_SESSION["obj"] = $data;
	    HttpUtil::showErrorMessages($obj->errors->full_messages());
	    HttpUtil::redirect("form/" . ($obj->id ? : ""));
	}
    }
    
    HttpUtil::redirect("./");
}
?>