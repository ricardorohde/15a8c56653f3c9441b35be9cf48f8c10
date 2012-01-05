<?
session_start();

include("include/header2.php");

$atendente = unserialize($_SESSION['usuario_obj']);



$_SESSION['restaurante_administrado_id'] = 1;

if($_SESSION['restaurante_administrado_id']){
    $restaurante = $_SESSION['restaurante_administrado_id'];
}

$novoped=Pedido::all(array("order"=>"quando", "conditions"=>array("situacao = ? AND restaurante_id = ?","novo_pedido",$atendente->restaurante_id)));
$pedpre=Pedido::all(array("order"=>"quando", "conditions"=>array("situacao =? AND restaurante_id = ?","pedido_preparacao",$atendente->restaurante_id)));
$pedconcan=Pedido::all(array("order"=>"quando", "conditions"=>array("( situacao=? OR situacao=? ) AND restaurante_id = ?","pedido_concluido","cancelado",$atendente->restaurante_id)));

?>

 <link rel="stylesheet" type="text/css" href="css_/estilo_.css" >
 <script src="js/jquery-1.6.4.min.js"></script>
 <script>
 $(document).ready( function (){   
  $("#b_cancelar").click ( function (){
      if($("#copia").attr("value")!=""){
          if($("#copia_status").attr("value")!="pedcan"){
              $("#areatext").show();
              $("#b_cancelar").hide();
              $("#formulario").hide();
              $("#avancar").hide();
          }else{
              alert("Este pedido já está cancelado.");
          }
      }else{
          alert("Selecione um pedido primeiro.");
      }
  });
  
  $(".confirmar").click( function (){
          if($("#textapaga").attr("alterado")==0){
              alert("Por favor, digite o motivo do cancelamento.");
          }else{
              $("#form_cancelamento").submit();
          }
  });
  
  
  $(".novo_ped").mouseover(function(){
      $(this).css("background","#7DD");
  });
  
  $(".novo_ped").mouseout(function(){
      $(this).css("background","#FFD700");
  });
  
  $(".novo_ped").click(function(){
      pedido = $("#copia").attr("value");
      $("#dados_ped").load("php/controller/dados_pedido.php?ped="+pedido);
      $("#form_pag").load("php/controller/forma_pagamento_pedido.php?ped="+pedido);
      $("#deta_ped").load("php/controller/detalhes_pedido.php?ped="+pedido);
  });
  
  $(".ped_pre").mouseover(function(){
      $(this).css("background","#7DD");
  });
  
  $(".ped_pre").mouseout(function(){
      $(this).css("background","#3CB371");
  });
  
  $(".ped_pre").click(function(){
      pedido = $("#copia").attr("value");
      $("#dados_ped").load("php/controller/dados_pedido.php?ped="+pedido);
      $("#form_pag").load("php/controller/forma_pagamento_pedido.php?ped="+pedido);
      $("#deta_ped").load("php/controller/detalhes_pedido.php?ped="+pedido);
  });
  
  $(".ped_con").mouseover(function(){
      $(this).css("background","#7DD");
  });
  
  $(".ped_con").mouseout(function(){
      $(this).css("background","#4682B4");
  });
  
  $(".ped_con").click(function(){
      pedido = $("#copia").attr("value");
      $("#dados_ped").load("php/controller/dados_pedido.php?ped="+pedido);
      $("#form_pag").load("php/controller/forma_pagamento_pedido.php?ped="+pedido);
      $("#deta_ped").load("php/controller/detalhes_pedido.php?ped="+pedido);
  });
  
  $(".ped_can").mouseover(function(){
      $(this).css("background","#7DD");
  });
  
  $(".ped_can").mouseout(function(){
      $(this).css("background","#DD6666");
  });
  
  $(".ped_can").click(function(){
      pedido = $("#copia").attr("value");
      $("#dados_ped").load("php/controller/dados_pedido.php?ped="+pedido);
      $("#form_pag").load("php/controller/forma_pagamento_pedido.php?ped="+pedido);
      $("#deta_ped").load("php/controller/detalhes_pedido.php?ped="+pedido);
  });
  
  $("#botao_avancar").click(function(){
      status_ = $("#copia_status").attr("value");
      pedido = $("#copia").attr("value");
      if(status_=="novoped"){
          $("#ped_pre").load("php/controller/update_pedidos.php?sta="+status_+"&ped="+pedido);
          $("#novo_ped").load("php/controller/refresh_pedidos.php?sta="+status_);
      }else if(status_=="pedpre"){
          $("#ped_con_can").load("php/controller/update_pedidos.php?sta="+status_+"&ped="+pedido);
          $("#ped_pre").load("php/controller/refresh_pedidos.php?sta="+status_);
      }
  });
  
  $(".cancelartext").click(function(){
      $("#areatext").hide();
      $("#b_cancelar").show();
      $("#formulario").show();
      $("#avancar").show();
  });
     
 });
 

 
function copia(codigo,status){
     document.getElementById("copia").value = codigo;
     document.getElementById("copia2").value = codigo;
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
                 <table id="pedpre" class="table" border="1px solid black">
                     <? if($pedpre){
                            foreach ($pedpre as $np){
                                //$dh = strtodate('d/m/Y h:i:s',$np->quando);
                                $dh = $np->quando->format('d/m/Y - H:i');

                                $quebra = explode(" - ", $dh);
                                $data=$quebra[0];
                                $hora=$quebra[1];

                                        ?>
                     <tr id="linha0011" class="ped_pre" onclick="copia('<?= $np->id ?>','pedpre')" style="cursor:pointer;">
                        <td><?= $np->id ?></td>
                        <td><?= $np->consumidor->nome ?></td>
                        <td><?= $data ?></td>
                        <td><?= $hora ?></td>
                    </tr>
                    <? }}           ?>
                 </table>
            </div>
        
                <div id="ped_con_can">
                    <table id="pedconcan" class="table" border="1px solid black">
                        <? if($pedconcan){
                                foreach ($pedconcan as $np){
                                    //$dh = strtodate('d/m/Y h:i:s',$np->quando);
                                    $dh = $np->quando->format('d/m/Y - H:i');

                                    $quebra = explode(" - ", $dh);
                                    $data=$quebra[0];
                                    $hora=$quebra[1];

                                            ?>
                         <tr class="<?= $np->situacao=="pedido_concluido" ? "ped_con" : "ped_can"  ?>" onclick="copia('<?= $np->id ?>','<?= $np->situacao=="pedido_concluido" ? "ped_con" : "ped_can"  ?>')" style="cursor:pointer;">
                            <td><?= $np->id ?></td>
                            <td><?= $np->consumidor->nome ?></td>
                            <td><?= $data ?></td>
                            <td><?= $hora ?></td>
                        </tr>
                        <? }}           ?>
                        
                    </table>   
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
                    <form id="form_cancelamento" action="php/controller/cancela_pedido.php" method="POST">
                        <input type="hidden" id="copia2" name="copia2" value="">
                        <div name="areatext" id="areatext" style="width:100%; height:65%; display:none;">
                            <div id="textarea"><label>*</label>
                                <div style="float:left; width:80%; height:70%;">
                                    <textarea id="textapaga" alterado="0" onclick="apaga('textapaga')" name="textarea" value="por favor">Por favor,informe o motivo do cancelamento e pressione confirmar. Ou clique em cancelar para remover esta ação.</textarea>
                                </div>
                                <div style="float:left; width:15%; height:60%;"> 
                                    <input style="width:100%; height:60%; font-size:16pt" type="button" name="confirmar" class="confirmar" value="Confirmar">
                                    <input style="width:100%; height:40%; font-size:12pt; margin-top:15px; text-decoration:underline;" type="button" name="cancelartext" class="cancelartext" value="Cancelar"> 
                                </div>
                            </div>
                        </div>
                    
                        </form>       
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