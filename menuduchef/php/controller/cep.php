<?
include_once("../lib/config.php");

$cep = StringUtil::onlyNumbers($_POST['cep']);

if ($cep) {
    $enderecoCep = EnderecoCep::find_by_cep($cep);
    
    if($enderecoCep) {
	$enderecoConsumidor = new EnderecoConsumidor();
	$enderecoConsumidor->bairro_id = $enderecoCep->bairro_id;
	$enderecoConsumidor->cep = $enderecoCep->cep;
	$enderecoConsumidor->logradouro = $enderecoCep->logradouro;
	$_SESSION['endereco'] = serialize($enderecoConsumidor);
	
	HttpUtil::redirect('../../restaurantes');
    } else {
	HttpUtil::showErrorMessages(array("Cep não encontrado"));
	HttpUtil::redirect('../../');
    }
}
?>