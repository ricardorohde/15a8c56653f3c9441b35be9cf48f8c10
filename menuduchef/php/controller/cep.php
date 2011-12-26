<?

include_once("../lib/config.php");

$cep = $_POST['cep'];

if ($cep) {
    $enderecoCep = EnderecoCep::find_by_cep($cep);
    
    if($enderecoCep) {
	HttpUtil::redirect('../../restaurantes');
    } else {
	HttpUtil::showErrorMessages(array("Cep não encontrado"));
	HttpUtil::redirect('../../');
    }
}
?>