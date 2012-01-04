<?
session_start();

include("include/header2.php");

$atendente = unserialize($_SESSION['usuario_obj']);



$_SESSION['restaurante_administrado_id'] = 1;

if($_SESSION['restaurante_administrado_id']){
    $restaurante = $_SESSION['restaurante_administrado_id'];
}

$novoped=Pedido::all(array("order"=>"quando", "conditions"=>array("situacao = ? AND restaurante_id = ?","novo_pedido",$atendente->restaurante_id)));
$pedpre=Pedido::all(array("order"=>"quando", "conditions"=>array("situacao =? AND restaurante_id = ?","pedido_preparaçao",$atendente->restaurante_id)));
$pedconcan=Pedido::all(array("order"=>"quando", "conditions"=>array("( situacao=? OR situacao=? ) AND restaurante_id = ?","pedido_concluido","pedido_cancelado",$atendente->restaurante_id)));
?>

 <link rel="stylesheet" type="text/css" href="css_/estilo_.css" >
 <script src="js/jquery-1.6.4.min.js"></script>
 <script>
 $(document).ready( function (){   
  $("#b_cancelar").click ( function (){
      $("#areatext").show();
      $("#b_cancelar").hide();
  });
  
  $(".novo_ped").mouseover(function(){
      $(this).css("background","#7DD");
  });
  
  $(".novo_ped").mouseout(function(){
      $(this).css("background","#FFD700");
  });
  
  $("#botao_avancar").click(function(){
      status_ = $("#copia_status").attr("value");
      pedido = $("#copia").attr("value");
      if(status_=="novoped"){
          //$("#ped_pre").load("update_pedidos.php?sta="+status_+"&"+pedido);
          $("#novo_ped").load("refresh_pedidos.php?sta="+status_);
      }
  });
     
 });
 

 
function copia(codigo,status){
     document.getElementById("copia").value = codigo;
     document.getElementById("copia_status").value = status;
}
 function apaga(x) {
	conf = $("#"+x).attr('alterado');
	if(conf=='0'){
		document.getElementById(x).value = "";
		$("#"+x).attr('alterado','1');

	}
}
 </script>


    <div id="area">
       
      
        <div id="novo_ped">
         <div id="qualquer">
             <table id="novoped" class="table" border="1px solid black">
             <? if($novoped){
                    foreach ($novoped as $np){
                        //$dh = strtodate('d/m/Y h:i:s',$np->quando);
                        $dh = $np->quando->format('d/m/Y - H:i');
                        
                        $quebra = explode(" - ", $dh);
                        $data=$quebra[0];
                        $hora=$quebra[1];
                 
                                ?>
             <tr id="linha0011" class="novo_ped" onclick="copia('<?= $np->id ?>','novoped')" style="cursor:pointer;">
                <td><?= $np->id ?></td>
                <td><?= $np->consumidor->nome ?></td>
                <td><?= $data ?></td>
                <td><?= $hora ?></td>
            </tr>
            <? }}           ?>
            
          </table>
         </div>
        </div>
        
            <div id="ped_pre">
                 <table id="pedpre" class="table" border="1px solid black"></table>
            </div>
        
                <div id="ped_con_can">
                    <table id="pedconcan" class="table" border="1px solid black"></table>   
                </div>
                    
                   <div id="form_dado">
                
                <div id="dados_ped"></div>
                <div id="form_pag"></div>
                
                <div id="botoes">
                    
                    <div id="avancar">
                      <input type="button" name="avancar" id="botao_avancar" class="avancar" value="Avançar &raquo;" >  
                      <input type="hidden" id="copia" value="">
                      <input type="hidden" id="copia_status" value="">
                    </div>
                    
                    <div name="areatext" id="areatext" style="width:100%; height:65%; display:none;"><div id="textarea"><label>*</label><form><div style="float:left; width:80%; height:70%;"><textarea id="textapaga" alterado="0" onclick="apaga('textapaga')" name="textarea" value="por favor">Por favor,informe o motivo do cancelamento e precione confirmar. Ou clique em cancelar para remover esta ação.</textarea></div><div style="float:left; width:15%; height:60%;"> <input style="width:100%; height:60%; font-size:16pt" type="submit" name="confirmar" class="cofirmar" value="Confirmar"><input style="width:100%; height:40%; font-size:12pt; margin-top:15px; text-decoration:underline;" type="button" name="cancelartext" class="cancelartext" value="Cancelar"> </div></form></div></div>
                            
                 <div id="cance_busca">
                    <div id="cancelar">
                      <input id="b_cancelar" type="button" name="cancelar" class="cancelar" value="cancelar pedido" >
                    </div>
                    
                    <div id="formulario">
                        <form>
                            <table class="buscador">
                                <tr class="inp_buscar">
                                    <td><input type="button" name="botBuscar" class="buscar" value="Buscar Pedido" style="height:3em;"></td>
                                    <td><input type="text" name="buscar" style="width:30em; height:3em;" ></td>
                                </tr>
                             </table>
                        </form>
                    </div>
                  </div>
                   
                </div>
                            
                    </div>
                
                <div id="deta_ped"></div>
        
               
    
    
        
    </div>














