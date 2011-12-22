<?
session_start();

include("include/header2.php");

$_SESSION['restaurante_administrado_id'] = 1;

if($_SESSION['restaurante_administrado_id']){
    $restaurante = $_SESSION['restaurante_administrado_id'];
}

$novoped=Pedido::all(array("order"=>"quando", "conditions"=>array("situacao=?","novo_pedido")));
$pedpre=Pedido::all(array("order"=>"quando", "conditions"=>array("situacao=?","pedido_preparaçao")));
$pedconcan=Pedido::all(array("order"=>"quando", "conditions"=>array("situacao=? OR situacao=?","pedido_concluido","pedido_cancelado")));
?>

 <link rel="stylesheet" type="text/css" href="css_/estilo_.css" >
 <script src="js/jquery-1.6.4.min.js"></script>
 <script>
 $(document).ready( function (){
  $("#b_cancelar").click ( function (){
      $("#areatext").show();
      $("#b_cancelar").hide();
  });
     
 });
 
 function addtr(){
     if(document.getElementById("codigo_t").value!=""){
         codigo=document.getElementById("codigo_t").value;
         nome=document.getElementById("nome_t").value;
         data=document.getElementById("data_t").value;
         hora=document.getElementById("hora_t").value;
         alvo=document.getElementById("alvo_t").value;
         
         continua = 1;
         switch(alvo){
            case"pedpre":alvo="pedconcan"; classe = "ped_con"; break;
            case"novoped":alvo="pedpre"; classe = "ped_pre"; break;
            default: continua=0; break;
        }
        
        if(continua){
            $('#'+alvo).append($(
                "<tr id='linha"+codigo+"' class='"+classe+"' onclick='copia(\""+codigo+"\",\""+nome+"\",\""+data+"\",\""+hora+"\",\""+alvo+"\")'><td>"+codigo+"</td><td>"+nome+"</td><td>"+data+"</td><td>"+hora+"</td></tr>"
              ));

             $('#linha'+codigo).remove();

             document.getElementById("codigo_t").value = "";
             document.getElementById("nome_t").value = "";
             document.getElementById("data_t").value = "";
             document.getElementById("hora_t").value = "";
             document.getElementById("alvo_t").value = "";
         }
     }
 }
 
function copia(codigo,nome,data,hora,alvo){
    
     document.getElementById("codigo_t").value = codigo;
     document.getElementById("nome_t").value = nome;
     document.getElementById("data_t").value = data;
     document.getElementById("hora_t").value = hora;
     document.getElementById("alvo_t").value = alvo;
     

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
                        $dh = $np->quando;
                        $quebra = explode(" ", $dh);
                        $data=$quebra[0];
                        $hora=$quebra[1];
                 
                                ?>
             <tr id="linha0011" class="novo_ped" onclick="copia('<?= $np->id ?>','<?= $np->consumidor->nome ?>','<?= $data ?>','<?= $hora ?>','novoped')">
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
                      <input type="hidden" id="codigo_t" value="">
                      <input type="hidden" id="nome_t" value="">
                      <input type="hidden" id="data_t" value="">
                      <input type="hidden" id="hora_t" value="">
                      <input type="hidden" id="alvo_t" value="">
                      <input type="button" name="avancar" class="avancar" value="Avançar &raquo;" onclick="addtr()">
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














