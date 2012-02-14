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
 var pedidos, novos, preparo, concluidos, cancelados;
 
 function carregaPedidos() {
	  pedidos = $(".pedidos");
	  novos = $(".novo_ped");
	  preparo = $(".ped_pre");
	  concluidos = $(".ped_con");
	  cancelados = $(".ped_can");
 }

 function carregaColuna(url, idDiv) {
 	$.ajax({
			"url": url,
			"success": function(data) {
				$('#' + idDiv).empty().append($(data));
				
				carregaPedidos();
			}
  	});
 }
 
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

$(document).ready( function (){
	carregaPedidos();
	
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
	  
	  $("#botao_avancar").click(function(){
		  status_ = $("#copia_status").attr("value");
		  pedido = $("#copia").attr("value");
		  if(status_=="novoped"){
			  status2 = "pedpre";
			  carregaColuna("php/controller/update_pedidos.php?sta="+status2+"&ped="+pedido, 'ped_pre');
			  carregaColuna("php/controller/refresh_pedidos.php?sta="+status_+"&ped="+pedido, 'novo_ped');
		  }else if(status_=="pedpre"){
			  status2 = "pedconcan";
			  carregaColuna("php/controller/update_pedidos.php?sta="+status2+"&ped="+pedido, 'ped_con_can');
			  carregaColuna("php/controller/refresh_pedidos.php?sta="+status_+"&ped="+pedido, 'ped_pre');
		  }
		  
	  });
	  
	  $(".confirmar").click( function (){
			  if($("#textapaga").attr("alterado")==0){
				  alert("Por favor, digite o motivo do cancelamento.");
			  }else{
				  $("#form_cancelamento").submit();
			  }
	  });
	  
	  $(".cancelartext").click(function(){
		  $("#areatext").hide();
		  $("#b_cancelar").show();
		  $("#formulario").show();
		  $("#avancar").show();
	  });
	  
	  pedidos.mouseover(function(){
		  $(this).css("background","#7DD");
	  });
	  
	  novos.mouseout(function(){
		  $(this).css("background","#FFD700");
	  });
	  
	  preparo.mouseout(function(){
		  $(this).css("background","#3CB371");
	  });
	  
	  concluidos.mouseout(function(){
		  $(this).css("background","#4682B4");
	  });
	  
	  cancelados.mouseout(function(){
		  $(this).css("background","#DD6666");
	  });
	  
	  pedidos.click(function(){
		  $("#copia").attr("value",$(this).attr("idped"));
		  $("#copia2").attr("value",$(this).attr("idped"));
		  $("#copia_status").attr("value",$(this).attr("tipo"));
		  
		  pedido = $("#copia").attr("value");
		  carregaColuna("php/controller/dados_pedido.php?ped="+pedido, 'dados_ped');
		  carregaColuna("php/controller/forma_pagamento_pedido.php?ped="+pedido, 'form_pag');
		  carregaColuna("php/controller/detalhes_pedido.php?ped="+pedido, 'deta_ped');
	  });
});
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
             <tr class="novo_ped pedidos" idped="<?= $np->id ?>" tipo="novoped" style="cursor:pointer;">
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
                     <tr class="ped_pre pedidos" idped="<?= $np->id ?>" tipo="pedpre" style="cursor:pointer;">
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
                         <tr class="<?= $np->situacao=="pedido_concluido" ? "ped_con" : "ped_can"  ?> pedidos" idped="<?= $np->id ?>" tipo="<?= $np->situacao=="pedido_concluido" ? "ped_con" : "ped_can"  ?>" style="cursor:pointer;">
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