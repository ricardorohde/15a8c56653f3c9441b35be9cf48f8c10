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
	    HttpUtil::showInfoMessages(array("Exclusгo realizada com sucesso"));
	} catch (Exception $e) {
	    HttpUtil::showErrorMessages(array("Nгo foi possнvel realizar a exclusгo: hб dados associados a este registro"));
	}
    } else {
	$obj->set_attributes($data);
	
	if($_FILES) {
	    foreach($_FILES as $param => $file) {
		
		$handle = new upload($file);
		
		if($handle->uploaded) {
		    $resize_x = array_key_exists('image_x', get_object_vars($obj));
		    $resize_y = array_key_exists('image_y', get_object_vars($obj));
		    
		    if($resize_x || $resize_y) {
			$handle->image_resize = true;
			
			if($resize_x) {
			    $handle->image_x = $obj->image_x;
			    if(!$resize_y) {
				$handle->image_ratio_y = true;
			    }
			}
			
			if($resize_y) {
			    $handle->image_y = $obj->image_y;
			    if(!$resize_x) {
				$handle->image_ratio_x = true;
			    }
			}
		    }
		    
		    $handle->process('../../' . PATH_IMAGE_UPLOAD . '/' . strtolower(get_class($obj)));
		    
		    if ($handle->processed) {
			$obj->assign_attribute($param, $handle->file_dst_name);
		    }
		}
	    }
	}
	
	$obj->save();

	if ($obj->is_valid() && $obj->errors->is_empty()) {
	    if ($id) {
		HttpUtil::showInfoMessages(array("Modificaзгo realizada com sucesso"));
	    } else {
		HttpUtil::showInfoMessages(array("Cadastro realizado com sucesso"));
	    }
	} else {
	    $_SESSION["obj"] = $data;
	    HttpUtil::showErrorMessages($obj->errors->full_messages());
	    HttpUtil::redirect("../../area_usuario");
	}
    }

    if ($redirect) {
	HttpUtil::redirect("../../area_usuario");
    }
}
?>