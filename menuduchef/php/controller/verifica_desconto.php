<?
include_once("../lib/config.php");

$restaurante = Restaurante::find($_GET['res']);

$cod = $_GET["cod"];
$quebra = str_split($cod);
$codigo = array_reverse($quebra);

if(sizeof($codigo)>11){
    $tam = sizeof($codigo) - 11;
    $num = "";
    for($i=0;$i<$tam;$i++){
        $num .= $codigo[$i+1];
    }
}else{
    $num = 0;
}

$lo = 0;

try{
    $lote = LoteCupom::find($num);

    if($lote){
        $nomelote = str_split($lote->nome);
        $nomelote = array_reverse($nomelote);

        if($nomelote[3]){
            if(strtoupper($nomelote[3])==strtoupper($codigo[0])){
                $lo = $lote->id;
            }
        }else{
            if(strtoupper($nomelote[0])==strtoupper($codigo[0])){
                $lo = $lote->id;
            }
        }
    }
    if($lo){
        $cupom = Cupom::find_by_codigo($cod);
        $aceita=RestauranteAceitaCupom::find_by_lotecupom_id_and_restaurante_id($cupom->lotecupom_id,$restaurante->id);
        if($aceita){
            if($cupom->usado){
                echo "Desconto:<div style='color:#EE646B; display:inline'> R$ 0,00</div><input type='hidden' id='valor_desconto' value='0'>";
                echo "<script>alert('Este c\u00f3digo j\u00e1 foi utilizado.')</script>";
            }else{
                $data_atual = date("Y-m-d h:i:s");
                
                if($data_atual<=$cupom->lote_cupom->validade->format("Y-m-d h:i:s")){
                    echo "Desconto:<div style='color:#EE646B; display:inline'> ".StringUtil::doubleToCurrency($cupom->valor)."</div><input type='hidden' id='valor_desconto' value='".$cupom->valor."'>";
                }else{
                    echo "Desconto:<div style='color:#EE646B; display:inline'> R$ 0,00</div><input type='hidden' id='valor_desconto' value='0'>";
                    echo "<script>alert('Cupom com data expirada.')</script>";
                }
            }
        }else{
            echo "Desconto:<div style='color:#EE646B; display:inline'> R$ 0,00</div><input type='hidden' id='valor_desconto' value='0'>";
            echo "<script>alert('Este restaurante n\u00e3o aceita este cupom.')</script>";
        }
    }else{
        echo "Desconto:<div style='color:#EE646B; display:inline'> R$ 0,00</div><input type='hidden' id='valor_desconto' value='0'>";
    }
} catch (ActiveRecord\RecordNotFound $e) {
    echo "Desconto:<div style='color:#EE646B; display:inline'> R$ 0,00</div><input type='hidden' id='valor_desconto' value='0'>";
    echo "<script>alert('C\u00f3digo inv\u00e1lido')</script>";
}

?>