<?
include("include/header.php");

//$itens = Produto::find_all_by_restaurante_id($_GET['id'], array("order" => "nome asc"));
if ($enderecoSession) {
    $categorias = RestauranteTemTipoProduto::all(array("order"=>"ordem",'conditions' => array('restaurante_id = ?', $_GET['id'])));
    $restaurante = Restaurante::find($_GET['id']);
    $rxb = RestauranteAtendeBairro::find(array('conditions' => array('restaurante_id = ? and bairro_id=?', $_GET['id'], $enderecoSession->bairro_id)));
}

function invoca_produto($prod,$c,$display,$menor,$maior){
    
    $restaurante = Restaurante::find($_GET['id']); //estranho isso, mas tive que fazer..
    
    $box_produto = '<div id="box_produto_'.$prod->id.'" class="produto" style="'; 
        if ($c % 2 == 1) {
				$box_produto .= 'background:#F0F0F0;';
			    }
        if ($display==0) {
				$box_produto .= 'display:none;';
			    }
    $box_produto .= '">';
        $box_produto .= '<div class="titulo_produto">'.$prod->nome;            

            $tem_extr = 0;
            if($prod->produto_tem_produtos_adicionais){
                foreach($prod->produto_tem_produtos_adicionais as $aaa){
                    if(($aaa->produto_adicional->quantas_unidades_ocupa==0)&&($aaa->produto_adicional->ativo==1)&&($aaa->produto_adicional->disponivel==1)){
                        $tem_extr = 1;
                    }
                }
            }
            
            if($prod->tamanho!=""){
                $box_produto .= '&nbsp;&nbsp;<div class="link_extra" id="muda_tamanho_'.$prod->id.'" produto="'.$prod->id.'"><span class="diminui" qual="'.$prod->id.'" menor="'.$menor.'" style="color:F00; cursor:pointer;">< </span>'.$prod->tamanho.'<span class="aumenta" qual="'.$prod->id.'" maior="'.$maior.'" style="color:F00; cursor:pointer;"> ></span></div>';
            }
            $box_produto .= '<input type="hidden" id="carda_tamanho_'.$prod->id.'" value="'.$prod->tamanho.'">';
            
            
            if($prod->aceita_segundo_sabor){
                $box_produto .= '<input type="hidden" id="aceita_seg_sab_'.$prod->id.'" value="1">';
                $box_produto .= '&nbsp;&nbsp;<div class="link_extra mostra_sabor_extra" style="font-size:17px;" produto="'.$prod->id.'">M</div>';
            }else{
                $box_produto .= '<input type="hidden" id="aceita_seg_sab_'.$prod->id.'" value="0">';
            }
            
            if($tem_extr){
                $box_produto .= '&nbsp;&nbsp;<div class="link_extra mostra_extra" id="link_extra_'.$prod->id.'" produto="'.$prod->id.'"> +extras</div>';                         
            }                                                               

            

        $box_produto .= '</div>';
                                
        $box_produto .= '<div class="sup_produto">';                        
            $box_produto .= '<div class="define_quantidade">'; 
                $box_produto .= '<div style="float:right">';
                    $box_produto .= '<img src="background/seta_down.gif" class="down" qual="'.$prod->id.'" width="10" height="10" style="cursor:pointer" />';
		$box_produto .= '</div>';			        
		$box_produto .= '<div style="float:right; margin:0 3px;">';		    
                    $box_produto .= '<input type="hidden" value="1" name="qtd_'.$prod->id.'" id="qtd_'.$prod->id.'" /><div id="qtd2_'.$prod->id.'">1</div>';
		$box_produto .= '</div>';				    
		$box_produto .= '<div style="float:right">';				
                    $box_produto .= '<img src="background/seta_up.gif" class="up" qual="'.$prod->id.'" width="10" height="10" style="cursor:pointer" />';
		$box_produto .= '</div>';			
            $box_produto .= '</div>';
           $box_produto .= '<div class="preco_produto" >';
            if($prod->esta_em_promocao){
		$box_produto .= '<span style="color:#666; font-size:10px; text-decoration: line-through;">'.StringUtil::doubleToCurrency($prod->preco).'</span>';		    
                $box_produto .= '&nbsp;&nbsp;<span>'.StringUtil::doubleToCurrency($prod->preco_promocional).'</span>';                        
            }else{
                $box_produto .= '<span>'.StringUtil::doubleToCurrency($prod->preco).'</span>';                            
            } 
	    $box_produto .= '</div>';
            if($prod->esta_em_promocao){ 
                $var = $prod->preco_promocional;
            }else{
                $var = $prod->preco;
            }            
            $box_produto .= '<input type="hidden" id="carda_preco_'.$prod->id.'" value="'.$var.'">'; 
       $box_produto .= '</div>';
       $box_produto .= '<div class="texto_produto">'.$prod->descricao; 
       if($prod->esta_em_promocao){
            $box_produto .= '<div style="color:#E51B21;">'.$prod->texto_promocao.'</div>';
       }
       $box_produto .= '</div>';
       $box_produto .= '<div style="width:230px; height:21px; float:right; padding-top:10px;">';
            $box_produto .= '<div style="float:right; position:relative;">';
                $box_produto .= '<input type="hidden" id="carda_id_'.$prod->id.'" value="'.$prod->id.'">';
                $box_produto .= '<input type="hidden" id="carda_nome_'.$prod->id.'" value="'.$prod->nome.'">';
                if($prod->aceita_segundo_sabor){
                    $sss=Produto::all(array("conditions"=>array("restaurante_id = ? AND ativo = ? AND disponivel = ? AND aceita_segundo_sabor = ? AND tamanho = ?",$restaurante->id,1,1,1,$prod->tamanho)));
                    //$sss=Produto::find_by_sql("SELECT * FROM produto WHERE restaurante_id = '".$restaurante->id."' AND ativo = '1' AND disponivel = '1' AND aceita_segundo_sabor = '1' AND tamanho = '".$prod->tamanho."'");
                    if($sss){
                        
                        if($restaurante->qtd_max_sabores==2){
                            $titulo = "Selecione o outro sabor";
                        }else{
                            $titulo = "Selecione os outros sabores";
                        }
                        $box_produto .= '<div class="carda_segundosabor_'.$prod->id.' pop-follow" style="position:absolute; z-index:999; left:-500px; top:-200px; display:none;">';
                            $box_produto .= '<img src="background/logo_noback.png" height="48" width="46" style="position:absolute; top:2px; left:4px; z-index:2; "> <img class="fechar_segundosabor"  produto="'.$prod->id.'" src="background/close.png" height="22" width="22" style="position:absolute; top:6px; right:3px; z-index:2; cursor:pointer;">';
                            $box_produto .= '<div style="width:264px; position:relative; float:left; margin:8px 0; background:#F4F4F4;">';
                                $box_produto .= '<div class="titulo_follow">'.$titulo.'</div>';
                            $box_produto .= '</div>';
                            $box_produto .= '<table>';
                            
                            $vezes = $restaurante->qtd_max_sabores - 1;
                            for($i=0;$i<$vezes;$i++){
                                $sabor = "";
                                switch($i){
                                    case 0: $sabor="Segundo sabor:"; break;
                                    case 1: $sabor="Terceiro sabor:"; break;
                                    case 2: $sabor="Quarto sabor:"; break;
                                }

                                $box_produto .= '<input type="hidden" id="carda_sabor_extra_preco_incluso_'.$prod->id.'_'.($i + 2).'" value="0">';
                                $box_produto .= '<tr><th>'.$sabor.'<input type="hidden" id="carda_sabor_extra_id_'.$prod->id.'_'.($i + 2).'" value="0"></th><th class="carda_sabor_extra_tabelinha_'.$prod->id.'" id="carda_sabor_extra_'.$prod->id.'_'.($i + 2).'">Nenhum</th></tr>';

                            }
                            $box_produto .= '</table>';
                            $box_produto .= '<table style="background:#F4F4F4; font-size:12px; width:264px; color:#999; float:left; position:relative; margin-top:10px;">';
                                foreach($sss as $ss){
                                    
                                    if($prod->esta_em_promocao){
                                        $precop = $prod->preco_promocional;
                                    }else{
                                        $precop = $prod->preco;
                                    }
                                    if($ss->esta_em_promocao){
                                        $precos = $ss->preco_promocional;
                                    }else{
                                        $precos = $ss->preco;
                                    }
                                    $precoss = $precos - $precop;
                                    if($precoss<0){
                                        $precoss=0;
                                    }
                                    $box_produto .= '<input type="hidden" class="carda_sabor_extra_preco_'.$prod->id.'" id="carda_sabor_extra_preco_'.$prod->id.'_'.$ss->id.'" value="'.$precoss.'">';
                                    $box_produto .= '<tr>';
                                        $box_produto .= '<td>';
                                            $box_produto .= '<img src="background/botao_add.gif" id="carda_sabor_extra_add_'.$prod->id.'_'.$ss->id.'" height="16" width="20" class="poe_segundo" produto="'.$prod->id.'_'.$ss->id.'" style="cursor:pointer;" />';
                                        $box_produto .= '</td>';
                                        $box_produto .= '<td colspan="2" id="carda_sabor_extra_nome_'.$prod->id.'_'.$ss->id.'">'.$ss->nome.'</td>';
                                        $box_produto .= '<td></td>';
                                        $box_produto .= '<td></td>';
                                        $box_produto .= '<td></td>';
                                    $box_produto .= '</tr>';
                                }
                                $box_produto .= '<tr>';
                                    $box_produto .= '<td></td>';
                                    $box_produto .= '<td  colspan="1" style="color:#E51B21;">Total</td>';
                                    $box_produto .= '<td></td>';
                                    $box_produto .= '<td id="carda_sabor_extra_total_'.$prod->id.'" colspan="2" style="color:#E51B21; font-size:9px;">+ R$0,00</td>';
                                    $box_produto .= '<td></td>';
                                $box_produto .= '</tr>';
                                $box_produto .= '<tr>';
                                    $box_produto .= '<td></td>';
                                $box_produto .= '</tr>';
                                $box_produto .= '<tr>';
                                    $box_produto .= '<td></td>';
                                $box_produto .= '</tr>';
                                $box_produto .= '<tr>';
                                    $box_produto .= '<td colspan="6" style="text-align:center;"><img class="confirmar_sabor_extra" style="cursor:pointer" produto="'.$prod->id.'" src="background/addc.png"></td>';
                                $box_produto .= '</tr>';
                           $box_produto .= '</table>';
                       $box_produto .= '</div>';
                    }
                }
                $tem_acomp = 0;
                $tem_extr = 0;
                if($prod->produto_tem_produtos_adicionais){
                    foreach($prod->produto_tem_produtos_adicionais as $aaa){
                        if(($aaa->produto_adicional->quantas_unidades_ocupa>0)&&($aaa->produto_adicional->ativo==1)&&($aaa->produto_adicional->disponivel==1)){
                            $tem_acomp = 1;
                        }
                        if(($aaa->produto_adicional->quantas_unidades_ocupa==0)&&($aaa->produto_adicional->ativo==1)&&($aaa->produto_adicional->disponivel==1)){
                            $tem_extr = 1;
                        }
                    }
                } 
                if($tem_acomp){
                    $box_produto .= '<div class="carda_acomp_'.$prod->id.' pop-follow" style="position:absolute; z-index:10; left:-500px; top:-200px; display:none;">';
                        $box_produto .= '<img src="background/logo_noback.png" height="48" width="46" style="position:absolute; top:2px; left:4px; z-index:2; "> <img class="fechar_acomp"  produto="'.$prod->id.'" src="background/close.png" height="22" width="22" style="position:absolute; top:6px; right:3px; z-index:2; cursor:pointer;">';
                        $box_produto .= '<div style="width:264px; position:relative; float:left; margin:8px 0; background:#F4F4F4;">';
                            $box_produto .= '<div class="titulo_follow">Acompanhamentos</div>';
                        $box_produto .= '</div>';    
                        $box_produto .= '<table style="background:#F4F4F4; font-size:12px; width:264px; color:#999; float:left; position:relative; margin-top:10px;">';    
                                            foreach($prod->produto_tem_produtos_adicionais as $aaa){ 
                                                 if(($aaa->produto_adicional->quantas_unidades_ocupa>0)&&($aaa->produto_adicional->ativo==1)&&($aaa->produto_adicional->disponivel==1)){
                                                        $box_produto .= '<input type="hidden" class="carda_acomp_preco_'.$prod->id.'" id="carda_acomp_preco_'.$prod->id.'_'.$aaa->produto_adicional->id.'" value="'.$aaa->produto_adicional->preco_adicional.'">';
                                                        $box_produto .= '<input type="hidden" id="carda_acomp_ocupa_'.$prod->id.'_'.$aaa->produto_adicional->id.'" value="'.$aaa->produto_adicional->quantas_unidades_ocupa.'">';                    
                                                        $box_produto .= '<tr>';
                                                            $box_produto .= '<td><img src="background/botao_add.gif" height="16" width="20" class="poe_acomp" produto="'.$prod->id.'_'.$aaa->produto_adicional->id.'" style="cursor:pointer;" /></td>';
                                                            $box_produto .= '<td id="carda_acomp_nome_'.$prod->id.'_'.$aaa->produto_adicional->id.'">'.$aaa->produto_adicional->nome.'</td>';    
                                                            $box_produto .= '<td class="carda_acomp_qtd_'.$prod->id.'" id="carda_acomp_qtd_'.$prod->id.'_'.$aaa->produto_adicional->id.'"></td>';
                                                            $box_produto .= '<td class="carda_acomp_preco_unitario_'.$prod->id.'" id="carda_acomp_preco_unitario_'.$prod->id.'_'.$aaa->produto_adicional->id.'"></td>';
                                                            $box_produto .= '<td></td>';
                                                            $box_produto .= '<td></td>';
                                                        $box_produto .= '</tr>';           
                                                 }
                                            }      
                                            $box_produto .= '<tr>';        
                                                $box_produto .= '<td></td>';            
                                                $box_produto .= '<td  colspan="1" style="color:#E51B21;">Total</td>';
                                                $box_produto .= '<td></td>';        
                                                $box_produto .= '<td id="carda_acomp_total_'.$prod->id.'" colspan="2" style="color:#E51B21; font-size:9px;">+ R$0,00</td>';            
                                                $box_produto .= '<td></td>';
                                            $box_produto .= '</tr>';
                                            $box_produto .= '<tr>';
                                                $box_produto .= '<td></td>';
                                            $box_produto .= '</tr>';
                                            $box_produto .= '<tr>';
                                                $box_produto .= '<td></td>';
                                            $box_produto .= '</tr>';
                                            $box_produto .= '<tr>';
                                                $box_produto .= '<td colspan="6" style="color:#F90; text-align:center;">Voc&ecirc; tem direito a <span id="acomp_direito_'.$prod->id.'" valor="'.$prod->qtd_produto_adicional.'">'.$prod->qtd_produto_adicional.'</span> por&ccedil;&otilde;es</td>';
                                            $box_produto .= '</tr>';
                                            $box_produto .= '<tr>';
                                                $box_produto .= '<td colspan="6" style="text-align:center;"><img class="poe_carrinho" quemsou="botao_add_acomp" style="cursor:pointer" produto="'.$prod->id.'" src="background/concluir.png"></td>';
                                            $box_produto .= '</tr>';
                       $box_produto .= '</table>';
                   $box_produto .= '</div>';     
                }    
                if($tem_extr){   
                    $box_produto .= '<div class="carda_extr_'.$prod->id.' pop-follow" style="position:absolute; z-index:10; left:-500px; top:-200px; display:none;">';
                        $box_produto .= '<img src="background/logo_noback.png" height="48" width="46" style="position:absolute; top:2px; left:4px; z-index:2; "> <img class="fechar_extr"  produto="'.$prod->id.'" src="background/close.png" height="22" width="22" style="position:absolute; top:6px; right:3px; z-index:2; cursor:pointer;">';
                        $box_produto .= '<div style="width:264px; position:relative; float:left; margin:8px 0; background:#F4F4F4;">';
                            $box_produto .= '<div class="titulo_follow">Extras</div>';
                        $box_produto .= '</div>';
                        $box_produto .= '<table style="background:#F4F4F4; font-size:12px; width:264px; color:#999; float:left; position:relative; margin-top:10px;">';
                            foreach($prod->produto_tem_produtos_adicionais as $aaa){ 
                                if(($aaa->produto_adicional->quantas_unidades_ocupa==0)&&($aaa->produto_adicional->ativo==1)&&($aaa->produto_adicional->disponivel==1)){
                                    $box_produto .= '<input type="hidden" class="carda_extr_preco_'.$prod->id.'" id="carda_extr_preco_'.$prod->id.'_'.$aaa->produto_adicional->id.'" value="'.$aaa->produto_adicional->preco_adicional.'">';
                                    $box_produto .= '<input type="hidden" id="carda_extr_ocupa_'.$prod->id.'_'.$aaa->produto_adicional->id.'" value="'.$aaa->produto_adicional->quantas_unidades_ocupa.'">';
                                    $box_produto .= '<tr>';
                                        $box_produto .= '<td><img src="background/botao_add.gif" height="16" width="20" class="poe_extr" produto="'.$prod->id.'_'.$aaa->produto_adicional->id.'" style="cursor:pointer;" /></td>';
                                        $box_produto .= '<td id="carda_extr_nome_'.$prod->id.'_'.$aaa->produto_adicional->id.'">'.$aaa->produto_adicional->nome.'</td>';
                                        $box_produto .= '<td class="carda_extr_qtd_'.$prod->id.'" id="carda_extr_qtd_'.$prod->id.'_'.$aaa->produto_adicional->id.'"></td>';
                                        $box_produto .= '<td class="carda_extr_preco_unitario_'.$prod->id.'" id="carda_extr_preco_unitario_'.$prod->id.'_'.$aaa->produto_adicional->id.'"></td>';
                                        $box_produto .= '<td></td>';
                                        $box_produto .= '<td></td>';
                                    $box_produto .= '</tr>';
                                    $box_produto .= '';
                                    $box_produto .= '';
                                }
                            }
                            $box_produto .= '<tr>';
                                $box_produto .= '<td></td>';
                                $box_produto .= '<td  colspan="1" style="color:#E51B21;">Total</td>';
                                $box_produto .= '<td></td>';
                                $box_produto .= '<td id="carda_extr_total_'.$prod->id.'" colspan="2" style="color:#E51B21; font-size:9px;">+ R$0,00</td>';
                                $box_produto .= '<td></td>';
                            $box_produto .= '</tr>';
                            $box_produto .= '<tr>';
                                $box_produto .= '<td></td>';
                            $box_produto .= '</tr>';
                            $box_produto .= '<tr>';
                                $box_produto .= '<td></td>';
                            $box_produto .= '</tr>';
                            $box_produto .= '<tr>';
                                $box_produto .= '<td colspan="6" style="text-align:center;"><img class="confirmar_extr" style="cursor:pointer" produto="'.$prod->id.'" src="background/addc.png"></td>';
                            $box_produto .= '</tr>';
                            $box_produto .= '<tr>';
                                $box_produto .= '<td colspan="6" style="text-align:center;"></td>';
                            $box_produto .= '</tr>';
                       $box_produto .= '</table>';
                   $box_produto .= '</div>';
                }        
                $box_produto .= '<img class="poe_carrinho" quemsou="botao_add" produto="'.$prod->id.'" src="background/botao_add.gif" width="25" height="21" style="margin:0 8px; cursor:pointer;"/>';        
            $box_produto .= '</div>';         
            $box_produto .= '<div style="float:right; color:#FFF; font-family:Arial; font-size:12px; width:60px; margin-right:15px; height:18px; padding-top:3px; background:#B2B2B2; border:0; font-weight:bold; position:relative;" class="radios">';
                $opacity = "opacity:0.4; filter:alpha(opacity=40);";
                $imag = "";
                if($prod->imagem!=""){
                    $opacity = "opacity:1; filter:alpha(opacity=100);";
                    $imag = "class='botao_foto'";
                }
            
                $box_produto .= '<img '.$imag.' qual="'.$prod->id.'" src="background/_cam.png" width="16" height="15" style="margin-left:8px;  position:absolute; '.$opacity.'"/><span style="margin-left:30px; color:#EFEFEF; cursor:pointer;" class="botao_obs" onclick="show(\'carda_obs_'.$prod->id.'\')" id="botao_obs_'.$prod->id.'">Obs</span>'; 
                if($prod->imagem!=""){
                    $box_produto .= '<img style="position:absolute; display:none; z-index:10; border:1px solid #F90;" id="foto_'.$prod->id.'" src="images/produto/'.$prod->imagem.'">';
                }
            $box_produto .= '</div>'; 
        $box_produto .= '</div>';
    $box_produto .= '<div id="obs_box_'.$prod->id.'">';    
        $box_produto .= '<textarea id="carda_obs_'.$prod->id.'" style="width:300px; height:40px; display:none;"></textarea>';
    $box_produto .= '</div>';                  
    $box_produto .= '</div>';
    
    return $box_produto;
}

$cuidado_apertar_minha_conta = 1;

$ped=Pedido::find($_SESSION['pedido_id']);
if($ped){
    $cup=Cupom::find($ped->cupom_id);
    if($cup){
        $corrig2['pedido_id'] = NULL;
        $corrig2['usado'] = 0;
        $cup->update_attributes($corrig2);
    }
    $corrig['cupom_id'] = NULL;
    $ped->update_attributes($corrig);
}

if($_POST){
    if($_POST['action']=='finaliza_carrinho'){
     $hora_atual = date("U");   
     if(($hora_atual - $restaurante->online)<=30){   
        $de_buenas = 1;
        foreach($_POST as $key => $valor){
            if(substr($key,0,9)=="qtd_prod_"){
                if($valor<1){
                    $de_buenas = 0;
                }
            }
        }
        if($de_buenas){
            if($_SESSION['pedido_id']){
                $idped = $_SESSION['pedido_id'];
                unset($_SESSION['cupom_id']);
                $prods=PedidoTemProduto::all(array("conditions"=>array("pedido_id = ?",$idped)));
                foreach($prods as $prod){
                    $prod->delete();
                }
                
                if($_POST['codigo_promocao']!=""){

                    $cod = $_POST['codigo_promocao'];
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
                                if($cupom->usado==0){
                                    $data_atual = date("Y-m-d h:i:s");

                                    if($data_atual<=$cupom->lote_cupom->validade->format("Y-m-d h:i:s")){
                                        $atucup['usado'] = 1;
                                        $cupom->update_attributes($atucup);
                                        $_SESSION['cupom_id'] = $cupom->id;

                                    }
                                }
                            }
                        }
                    }catch (ActiveRecord\RecordNotFound $e) {
                        //nada acontece
                    }
                }
                
            }else{
                
                    $data['consumidor_id'] = $consumidorSession->id;
                    $data['restaurante_id'] = $restaurante->id;
                    $data['forma_pagamento'] = "ainda_nao";
                    $data['troco'] = 0;
                    if($_POST['codigo_promocao']!=""){

                        $cod = $_POST['codigo_promocao'];
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
                                    if($cupom->usado==0){
                                        $data_atual = date("Y-m-d h:i:s");

                                        if($data_atual<=$cupom->lote_cupom->validade->format("Y-m-d h:i:s")){
                                            $atucup['usado'] = 1;
                                            $cupom->update_attributes($atucup);
                                            $_SESSION['cupom_id'] = $cupom->id;
                                            
                                        }
                                    }
                                }
                            }
                        }catch (ActiveRecord\RecordNotFound $e) {
                            //nada acontece
                        }
                    }  
                    $data['endereco'] = "";
                    $data['situacao'] = "";
                    $data['pagamento_efetuado'] = 0;
                    $data['preco_entrega'] = $rxb->preco_entrega;
                    $data['endereco_id'] = $enderecoSession->id;

                    if($_SESSION['usuario']){
                        $ped = new Pedido($data);
                        $ped->save();

                        if($ped->is_invalid()) {
                            HttpUtil::showErrorMessages($ped->errors->full_messages());
                            HttpUtil::redirect($_SERVER['REQUEST_URI']);
                        }
                        
                        $idped = $ped->id;
                        $_SESSION['pedido_id'] = $idped;
                    }else{
                        $_SESSION['pedido_aguardando'] = serialize($data);
                    }
            }
            $count_aguardando = 0;
            $count_adicional_aguardando = 0;
            foreach($_POST as $key => $valor){
                if(substr($key,0,8)=="id_prod_"){                 
                    $quebra = explode("_",$key);
                    $prodok = 1;
                    if(strpbrk($valor,'/')){
                        
                        $prodqueb = explode("/",$valor);
                        $prod=Produto::find(array("conditions"=>array("restaurante_id = ? AND id = ? AND ativo = ? AND disponivel = ?",$restaurante->id,$prodqueb[0],1,1)));
                        if(!$prod){
                            $prodok = 0;
                        }
                        if((sizeof($prodqueb)>1)&&($prodqueb[1])){
                            $prod2=Produto::find(array("conditions"=>array("restaurante_id = ? AND id = ? AND ativo = ? AND disponivel = ?",$restaurante->id,$prodqueb[1],1,1)));
                            if(!$prod2){
                                $prodok = 0;
                            }
                        }
                        if((sizeof($prodqueb)>2)&&($prodqueb[2])){
                            $prod3=Produto::find(array("conditions"=>array("restaurante_id = ? AND id = ? AND ativo = ? AND disponivel = ?",$restaurante->id,$prodqueb[2],1,1)));
                            if(!$prod3){
                                $prodok = 0;
                            }
                        }
                        if((sizeof($prodqueb)>3)&&($prodqueb[3])){
                            $prod4=Produto::find(array("conditions"=>array("restaurante_id = ? AND id = ? AND ativo = ? AND disponivel = ?",$restaurante->id,$prodqueb[3],1,1)));
                            if(!$prod4){
                                $prodok = 0;
                            }
                        }
                    }else{
                        
                        $prod=Produto::find(array("conditions"=>array("restaurante_id = ? AND id = ? AND ativo = ? AND disponivel = ?",$restaurante->id,$valor,1,1)));
                        if(!$prod){
                            $prodok = 0;
                        }
                    }

                    if($prodok){
                        $data2['pedido_id'] = $idped;
                        $data2['produto_id'] = $prod->id;
                        $data2['qtd'] = $_POST['qtd_prod_'.$quebra[2]];
                        $data2['obs'] = $_POST['obs_prod_'.$quebra[2]];
                        $data2['tamanho'] = "";
                        if($prod2){
                            $data2['produto_id2'] = $prod2->id;
                            if($prod3){
                                $data2['produto_id3'] = $prod3->id;
                                if($prod4){
                                    $data2['produto_id4'] = $prod4->id;
                                }else{
                                    $data2['produto_id4'] = 0;
                                }
                            }else{
                                $data2['produto_id4'] = 0;
                                $data2['produto_id3'] = 0;
                            }
                        }else{
                            $data2['produto_id4'] = 0;
                            $data2['produto_id3'] = 0;
                            $data2['produto_id2'] = 0;
                        }
                       
                        if($prod->esta_em_promocao){ //conferir se os precos dos outros pedacos tao senod elvados em conta
                            $data2['preco_unitario'] = $prod->preco;
                        }else{
                            $data2['preco_unitario'] = $prod->preco_promocional;
                        }
                        
                        unset($prod2);
                        unset($prod3);
                        unset($prod4);
                        
                        if($_SESSION['usuario']){
                            $pro = new PedidoTemProduto($data2);
                            $pro->save();
                        }else{
                            $_SESSION['produto_aguardando'][$count_aguardando] = serialize($data2);
                            
                        }
                        $qtd_acomp = $prod->qtd_produto_adicional;
                        
                        foreach($_POST as $key2 => $valor2){
                            
                            
                                
                                if(substr($key2,0,9)=="adi_prod_"){
                                    
                                    $quebra2 = explode("_",$key2);
                                    
                                    if($quebra2[2]==$quebra[2]){
                                        
                                        $conf_elo = 0;

                                        if($prod->produto_tem_produtos_adicionais){
                                            foreach($prod->produto_tem_produtos_adicionais as $aaa){
                                                
                                                if($aaa->produtoadicional_id==$valor2){
                                                    $conf_elo = 1;
                                                }
                                            }
                                        }
                                        if($conf_elo){
                                            
                                            $prodadi=ProdutoAdicional::find(array("conditions"=>array("restaurante_id = ? AND id = ? AND ativo = ? AND disponivel = ? AND quantas_unidades_ocupa <= ?",$restaurante->id,$valor2,1,1,$qtd_acomp)));
                                            if($prodadi){
                                                if(($qtd_acomp -$prodadi->quantas_unidades_ocupa)>=0){
                                                    if($_SESSION['usuario']){
                                                        $data3['pedidotemproduto_id'] = $pro->id;
                                                    }else{
                                                        $data3['pedidotemproduto_id'] = 0; 
                                                    }
                                                    $data3['produtoadicional_id'] = $prodadi->id;
                                                    $data3['preco'] = $prodadi->preco_adicional;

                                                    if($_SESSION['usuario']){
                                                        $ptpa = new PedidoTemProdutoAdicional($data3);
                                                        $ptpa->save();
                                                    }else{
                                                        $_SESSION['produto_adicional_aguardando'][$count_aguardando][$count_adicional_aguardando] = serialize($data3);
                                                        $count_adicional_aguardando++;
                                                    }

                                                    $qtd_acomp -= $prodadi->quantas_unidades_ocupa;
                                                }
                                            }
                                        }
                                    }
                                }
                            
                        }
                        if($_SESSION['usuario']){
                            
                        }else{
                            
                            $count_aguardando++;
                        }
                    }
                }
            }
            
            //finalizando o carrinho, chega a hora de decidir pra qual pagina ir: a do login ou a do pagamento:
            if($_SESSION['usuario']){
               echo "<script> location.href = '".URL_PRODUCTION."pagamento' </script>";
            }else{
               echo "<script> location.href = '".URL_PRODUCTION."cadastro' </script>";
            }
        }
        
    }else{
      $mensagem_fechado = 1;  
    }
  }  
}
?>
<script>
    
    function strpbrk (haystack, char_list) {
        for (var i = 0, len = haystack.length; i < len; ++i) {
            if (char_list.indexOf(haystack.charAt(i)) >= 0) {
                return haystack.slice(i);
            }
        }
        return false;
    }
    function getElementByClass(theClass) {
        var allHTMLTags = new Array();
        var selectedElements = new Array();
        var allHTMLTags=document.getElementsByTagName("*");
        for (i=0; i<allHTMLTags.length; i++) {
            if (allHTMLTags[i].className==theClass) {
                selectedElements.push(allHTMLTags[i]);
            }
        }
        return selectedElements;
    }
    
    function number_format( number, decimals, dec_point, thousands_sep ) {
        // %        nota 1: Para 1000.55 retorna com precisão 1 no FF/Opera é 1,000.5, mas no IE é 1,000.6
        // *     exemplo 1: number_format(1234.56);
        // *     retorno 1: '1,235'
        // *     exemplo 2: number_format(1234.56, 2, ',', ' ');
        // *     retorno 2: '1 234,56'
        // *     exemplo 3: number_format(1234.5678, 2, '.', '');
        // *     retorno 3: '1234.57'
        // *     exemplo 4: number_format(67, 2, ',', '.');
        // *     retorno 4: '67,00'
        // *     exemplo 5: number_format(1000);
        // *     retorno 5: '1,000'
        // *     exemplo 6: number_format(67.311, 2);
        // *     retorno 6: '67.31'

        var n = number, prec = decimals;
        n = !isFinite(+n) ? 0 : +n;
        prec = !isFinite(+prec) ? 0 : Math.abs(prec);
        var sep = (typeof thousands_sep == "undefined") ? ',' : thousands_sep;
        var dec = (typeof dec_point == "undefined") ? '.' : dec_point;

        var s = (prec > 0) ? n.toFixed(prec) : Math.round(n).toFixed(prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;

        var abs = Math.abs(n).toFixed(prec);
        var _, i;

        if (abs >= 1000) {
            _ = abs.split(/\D/);
            i = _[0].length % 3 || 3;

            _[0] = s.slice(0,i + (n < 0)) +
                  _[0].slice(i).replace(/(\d{3})/g, sep+'$1');

            s = _.join(dec);
        } else {
            s = s.replace('.', dec);
        }

        return s;
    }
</script>
<script>

    $(document).ready(function() {
        contador = 0; //usado pra impedir que o vetor com a lista de pedidos do carrinho se repita
        
        $(".botao_foto").mouseover(function(){
            qual = $(this).attr("qual");
            $("#foto_"+qual).show();
        });
        $(".botao_foto").mouseout(function(){
            qual = $(this).attr("qual");
            $("#foto_"+qual).hide();
        });
        $(".filtro_categoria").click( function(){
	    algum = 0;
            $(".filtro_categoria").each(function(){
                if($(this).attr("checked")){
                    algum = 1;
                }
            });
            if(algum){
                $(".filtro_categoria").each(function(){
                    if($(this).attr("checked")){
                        qual = $(this).attr("value");
                        $("#box_box_categoria_"+qual).show();
                    }else{
                        qual = $(this).attr("value");
                        $("#box_box_categoria_"+qual).hide();
                    }
                });
                
            }else{
                $(".filtro_categoria").each(function(){
                    qual = $(this).attr("value");
                    $("#box_box_categoria_"+qual).show();
                });
            }
	});
        
	$("#ver_completo").click( function(){
	    $(".filtro_categoria").attr("checked","true");
	    $(".categoria").show();
	});
        
        $(".diminui").click(function(){
            
            qual=$(this).attr("qual");
            menor=$(this).attr("menor");

            if(menor!="0"){
                $("#box_produto_"+qual).hide();
                $("#box_produto_"+menor).show();
            }
        });
        $(".aumenta").click(function(){
            qual=$(this).attr("qual");
            maior=$(this).attr("maior");
            
            if(maior!="0"){
                $("#box_produto_"+qual).hide();
                $("#box_produto_"+maior).show();
            }
        });
    
	$(".up").click( function(){
	    qual=$(this).attr("qual");
	    qtd=$("#qtd_"+qual).attr("value");
	    qtd= parseInt(qtd) + 1;
	    $("#qtd_"+qual).attr("value",qtd);
	    $("#qtd2_"+qual).html(qtd);	
	});
	
	$(".down").click( function(){
	    qual=$(this).attr("qual");
	    qtd=$("#qtd_"+qual).attr("value");
	    if(parseInt(qtd)>1){
		qtd= parseInt(qtd) - 1;
		$("#qtd_"+qual).attr("value",qtd);
		$("#qtd2_"+qual).html(qtd);
	    }
	});
	
	$("#filtrar").click( function(){
	    oque = $("#caixa_filtro").attr("value");
	    $(".produto").hide();
	    $("#produto_").hide();
        
	});
        $(".botao_obs").click(function(){
            id = $(this).attr("id");
            id = id.split("_");
            id = id[2];
            
            if($("#box_produto_"+id).css("height")=="115px"){
                $("#box_produto_"+id).css("height","60px");
            }else{
                $("#box_produto_"+id).css("height","115px");
            }

        });
	$('.abreformapagamento').mouseover(function() {
	    $("#formapagamento").show();
        });
        $('.abreformapagamento').mouseout(function() {
	    $("#formapagamento").hide();
        });
        $(".poe_destaque_carrinho").click( function(){
            prosseguir = 0;
            count = 0;
            $(".carda_destaque_acomp_"+$(this).attr("produto")).each(function(){
                $(this).show();
                count++;
            });
            if($(this).attr("quemsou")=="botao_add_acomp"){
                prosseguir = 1;
                $(".carda_destaque_acomp_"+$(this).attr("produto")).each(function(){
                    $(this).hide();
                });
            }
            if(count==0){
                prosseguir = 1;
            }
            if(prosseguir){
                idprod = $(this).attr("produto");
                qtd = 1;
                nome = $("#carda_nome_"+idprod).attr("value");
                
                if($("#carda_tamanho_"+idprod).attr("value")!=""){
                    nome += " "+$("#carda_tamanho_"+idprod).attr("value");
                }
                
                obsprod = "";
                              
                
                ja_tem_no_carrinho = 0;
                alvo = "";
                valor_total = 0; //esse é o valor de todos os itens somados, que da o total la do carrinho
                taxa_entrega = parseFloat($("#taxa_de_entrega").attr("value"));

                vetor = getElementByClass("lista_carrinho");

                for(var i in vetor){
                    qual = vetor[i].id;
                    if(qual.substr(0,7)=="id_prod"){
                        qual = qual.split("_");
                        if((qual[0]=="id")&&(qual[1]=="prod")){
                            if(confere_se_id_e_igual(vetor[i].value,idprod)){
                                obs = document.getElementById("obs_prod_"+qual[2]).value;

                                if(obs==obsprod){
                                    if(confere_se_acomp_e_igual(qual[2],idprod,"destaque")){    
                                        
                                            ja_tem_no_carrinho = 1;
                                            alvo = qual[2];
                                          
                                    }
                                }
                            }

                            valor_total += parseFloat(document.getElementById("preco_prod_"+qual[2]).value);
                        }
                    }
                }

                preco = obter_preco2(idprod);

                if(ja_tem_no_carrinho==0){
                    numero = parseInt(document.getElementById("contador_itens").value);
                    document.getElementById("contador_itens").value = numero + 1;
                    item_no_carrinho = '<div id="produto_box_'+numero+'" style="margin:5px;">';
                    item_no_carrinho += '<div onclick=\'destroi_box("'+numero+'")\'>X</div>';
                    item_no_carrinho += '<div><span id="span_qtd_prod_'+numero+'">'+qtd+'x</span>';
                    item_no_carrinho += '<input type="hidden" id="qtd_prod_'+numero+'" name="qtd_prod_'+numero+'" value="'+qtd+'">';
                    item_no_carrinho += nome;                        
                    item_no_carrinho += '<input type="hidden" id="id_prod_'+numero+'" name="id_prod_'+numero+'" class="lista_carrinho" value="'+idprod+'">';
                    preco *= qtd;
                    item_no_carrinho += '<div id="div_preco_prod_'+numero+'" style="float:right;">R$ '+number_format(preco, 2, ',', '.')+'</div>';
                    item_no_carrinho += '<input type="hidden" id="preco_prod_'+numero+'"  class="preco_carrinho" value="'+preco+'" >';
                    item_no_carrinho += '</div>';
                    
                    
                    if($(this).attr("quemsou")=="botao_add_acomp"){
                        item_no_carrinho += '<div>';
                        item_no_carrinho += arruma_destaque_acompanhamentos(idprod);
                        item_no_carrinho += '</div>';
                    }

                    item_no_carrinho += '<div>';
                    item_no_carrinho += '<span  style="font-size:10px;" id="span_obs_prod_'+numero+'">'+obsprod+'</span>';
                    item_no_carrinho += '<input type="hidden" id="obs_prod_'+numero+'" name="obs_prod_'+numero+'" value="'+obsprod+'">';
                    item_no_carrinho += '</div>';

                    item_no_carrinho += '</div>';

                    $('#campo_pedido_detalhado').append($(item_no_carrinho));

                    valor_total += preco;
                }else{
                    qtd_ = parseInt(qtd) + parseInt(document.getElementById("qtd_prod_"+alvo).value);
                    valor_total += (qtd * preco);
                    preco *= qtd_;
                    document.getElementById("qtd_prod_"+alvo).value = qtd_;
                    document.getElementById("span_qtd_prod_"+alvo).innerHTML = qtd_+"x";
                    document.getElementById("div_preco_prod_"+alvo).innerHTML = "R$ "+number_format(preco, 2, ',', '.');
                    document.getElementById("preco_prod_"+alvo).value = preco;
                }
                document.getElementById("subtotal_carrinho").innerHTML = "R$ "+number_format(valor_total, 2, ',', '.');
                valor_desconto = parseFloat(document.getElementById("valor_desconto").value);
                valor_total = valor_total - valor_desconto;
                if(valor_total<0){
                    valor_total = 0;
                }
                document.getElementById("total_carrinho").innerHTML = "R$ "+number_format((valor_total + taxa_entrega), 2, ',', '.');
                
                $(".carda_destaque_acomp_qtd_"+idprod).each(function(){
                    $(this).empty();
                });
                $(".carda_destaque_acomp_preco_unitario_"+idprod).each(function(){
                    $(this).empty();
                });
                $("#carda_destaque_obs_"+idprod).attr("value","");
                $("#carda_destaque_obs_"+idprod).hide();
                
                $(".carda_destaque_extr_"+idprod).each(function(){
                    
                    $(this).hide();
                });
                $(".carda_destaque_extr_qtd_"+idprod).each(function(){
                    $(this).empty();
                });

                $(".carda_destaque_extr_preco_unitario_"+idprod).each(function(){
                    $(this).empty();
                });


                $("#carda_destaque_extr_total_"+quebra[0]).html("+ R$ 0,00");
                

                $("#carda_destaque_acomp_total_"+idprod).html("+ R$0,00");
                dir = $("#acomp_destaque_direito_"+idprod).attr("valor");
                $("#acomp_destaque_direito_"+idprod).html(dir);
            }
            if($(this).attr("quemsou")=="botao_add_acomp"){
                $(".carda_destaque_acomp_qtd_"+$(this).attr("produto")).each(function(){
                    $(this).empty();
                });
            }
	});
        $(".poe_carrinho").click( function(){
            prosseguir = 0;
            count = 0;
            $(".carda_acomp_"+$(this).attr("produto")).each(function(){
                $(this).show();
                count++;
            });
            if($(this).attr("quemsou")=="botao_add_acomp"){
                prosseguir = 1;
                $(".carda_acomp_"+$(this).attr("produto")).each(function(){
                    $(this).hide();
                });
            }
            if(count==0){
                prosseguir = 1;
            }
            if(prosseguir){
                idprod = $(this).attr("produto");
                qtd = $("#qtd_"+idprod).attr("value");
                nome = $("#carda_nome_"+idprod).attr("value");
                
                obsprod = $("#carda_obs_"+idprod).attr("value");
                
                $("#link_extra_"+idprod).css("color","#F90");
                $("#link_extra_"+idprod).html(" +extras");
                $("#link_extra_"+idprod).css("font-size","9px");
                
                $("#box_produto_"+idprod).css("height","60px");
                
                ja_tem_no_carrinho = 0;
                alvo = "";
                valor_total = 0; //esse é o valor de todos os itens somados, que da o total la do carrinho
                taxa_entrega = parseFloat($("#taxa_de_entrega").attr("value"));

                vetor = getElementByClass("lista_carrinho");

                for(var i in vetor){
                    qual = vetor[i].id;
                    if(qual.substr(0,7)=="id_prod"){
                        qual = qual.split("_");
                        if((qual[0]=="id")&&(qual[1]=="prod")){
                            
                            if(confere_se_id_e_igual(vetor[i].value,idprod)){
                                obs = document.getElementById("obs_prod_"+qual[2]).value;

                                if(obs==obsprod){
                                    if(confere_se_acomp_e_igual(qual[2],idprod,"normal")){
                                        
                                            ja_tem_no_carrinho = 1;
                                            alvo = qual[2];
                                        
                                    }
                                }
                            }

                            valor_total += parseFloat(document.getElementById("preco_prod_"+qual[2]).value);
                        }
                    }
                }

                preco = obter_preco(idprod);

                if(ja_tem_no_carrinho==0){
                    numero = parseInt(document.getElementById("contador_itens").value);
                    document.getElementById("contador_itens").value = numero + 1;
                    item_no_carrinho = '<div id="produto_box_'+numero+'" style="margin:5px;">';
                    item_no_carrinho += '<div onclick=\'destroi_box("'+numero+'")\'>X</div>';
                    item_no_carrinho += '<div><span id="span_qtd_prod_'+numero+'">'+qtd+'x</span>';
                    item_no_carrinho += '<input type="hidden" id="qtd_prod_'+numero+'" name="qtd_prod_'+numero+'" value="'+qtd+'">';

                    if($("#aceita_seg_sab_"+idprod).attr("value")){
                        prodval = idprod;
                                               
                        if(parseInt($("#carda_sabor_extra_id_"+idprod+"_2").attr("value"))){
                           prodval += "/"+$("#carda_sabor_extra_id_"+idprod+"_2").attr("value");
                           if(parseInt($("#carda_sabor_extra_id_"+idprod+"_3").attr("value"))){
                               prodval += "/"+$("#carda_sabor_extra_id_"+idprod+"_3").attr("value");
                               if(parseInt($("#carda_sabor_extra_id_"+idprod+"_4").attr("value"))){
                                   prodval += "/"+$("#carda_sabor_extra_id_"+idprod+"_4").attr("value");
                                   prodnom = "1/4"+nome+",1/4"+$("#carda_sabor_extra_"+idprod+"_2").html()+",1/4"+$("#carda_sabor_extra_"+idprod+"_3").html()+",1/4"+$("#carda_sabor_extra_"+idprod+"_4").html();
                               }
                               else{
                                   prodnom = "1/3"+nome+",1/3"+$("#carda_sabor_extra_"+idprod+"_2").html()+",1/3"+$("#carda_sabor_extra_"+idprod+"_3").html();
                               }
                           }
                           else{
                               prodnom = "1/2"+nome+",1/2"+$("#carda_sabor_extra_"+idprod+"_2").html();
                           }
                        }else{
                            
                            prodnom = nome;
                        }

                    }else{
                        prodnom = nome;
                        prodval = idprod;
                    }
                    
                    if($("#carda_tamanho_"+idprod).attr("value")!=""){
                        prodnom += " "+$("#carda_tamanho_"+idprod).attr("value");
                    }

                    item_no_carrinho += prodnom;
                    item_no_carrinho += '<input type="hidden" id="id_prod_'+numero+'" name="id_prod_'+numero+'" class="lista_carrinho" value="'+prodval+'">';
                    preco *= qtd;
                    item_no_carrinho += '<div id="div_preco_prod_'+numero+'" style="float:right;">R$ '+number_format(preco, 2, ',', '.')+'</div>';
                    item_no_carrinho += '<input type="hidden" id="preco_prod_'+numero+'"  class="preco_carrinho" value="'+preco+'" >';
                    item_no_carrinho += '</div>';
                    
                    
                    if($(this).attr("quemsou")=="botao_add_acomp"){
                        item_no_carrinho += '<div>';
                        item_no_carrinho += arruma_acompanhamentos(idprod);
                        item_no_carrinho += '</div>';
                    }
                        item_no_carrinho += '<div>';
                        item_no_carrinho += arruma_extras(idprod);
                        item_no_carrinho += '</div>';
                                         
                                            
                                        

                    item_no_carrinho += '<div>';
                    item_no_carrinho += '<span  style="font-size:10px;" id="span_obs_prod_'+numero+'">'+obsprod+'</span>';
                    item_no_carrinho += '<input type="hidden" id="obs_prod_'+numero+'" name="obs_prod_'+numero+'" value="'+obsprod+'">';
                    item_no_carrinho += '</div>';

                    item_no_carrinho += '</div>';

                    $('#campo_pedido_detalhado').append($(item_no_carrinho));

                    valor_total += preco;
                }else{
                    qtd_ = parseInt(qtd) + parseInt(document.getElementById("qtd_prod_"+alvo).value);
                    valor_total += (qtd * preco);
                    preco *= qtd_;
                    document.getElementById("qtd_prod_"+alvo).value = qtd_;
                    document.getElementById("span_qtd_prod_"+alvo).innerHTML = qtd_+"x";
                    document.getElementById("div_preco_prod_"+alvo).innerHTML = "R$ "+number_format(preco, 2, ',', '.');
                    document.getElementById("preco_prod_"+alvo).value = preco;
                }
                document.getElementById("subtotal_carrinho").innerHTML = "R$ "+number_format(valor_total, 2, ',', '.');
                valor_desconto = parseFloat(document.getElementById("valor_desconto").value);
                valor_total = valor_total - valor_desconto;
                if(valor_total<0){
                    valor_total = 0;
                }
                document.getElementById("total_carrinho").innerHTML = "R$ "+number_format((valor_total + taxa_entrega), 2, ',', '.');
                
                $(".carda_acomp_qtd_"+idprod).each(function(){
                    $(this).empty();
                });
                $(".carda_acomp_preco_unitario_"+idprod).each(function(){
                    $(this).empty();
                });
                $("#carda_obs_"+idprod).attr("value","");
                $("#carda_obs_"+idprod).hide();
                
                $(".carda_extr_"+idprod).each(function(){
                    
                    $(this).hide();
                });
                $(".carda_extr_qtd_"+idprod).each(function(){
                    $(this).empty();
                });

                $(".carda_extr_preco_unitario_"+idprod).each(function(){
                    $(this).empty();
                });

                $("#carda_sabor_extra_total_"+quebra[0]).html("+ R$ 0,00");
                $("#carda_sabor_extra_preco_incluso_"+quebra[0]+"_2").attr("value",0);
                $("#carda_sabor_extra_preco_incluso_"+quebra[0]+"_3").attr("value",0);
                $("#carda_sabor_extra_preco_incluso_"+quebra[0]+"_4").attr("value",0);
                
                $("#carda_sabor_extra_id_"+idprod+"_2").attr("value",0);
                $("#carda_sabor_extra_id_"+idprod+"_3").attr("value",0);
                $("#carda_sabor_extra_id_"+idprod+"_4").attr("value",0);
                
                $("#carda_sabor_extra_"+quebra[0]+"_2").html("Nenhum");
                $("#carda_sabor_extra_"+quebra[0]+"_3").html("Nenhum");
                $("#carda_sabor_extra_"+quebra[0]+"_4").html("Nenhum");
                $("#carda_extr_total_"+quebra[0]).html("+ R$ 0,00");
                

                $("#carda_acomp_total_"+idprod).html("+ R$0,00");
                dir = $("#acomp_direito_"+idprod).attr("valor");
                $("#acomp_direito_"+idprod).html(dir);
            }
            if($(this).attr("quemsou")=="botao_add_acomp"){
                $(".carda_acomp_qtd_"+$(this).attr("produto")).each(function(){
                    $(this).empty();
                });
            }
            
            
            
	});
        $(".poe_acomp").click( function(){
        
            qual = $(this).attr("produto");
            quebra = qual.split("_");
            
            dir = parseInt($("#acomp_direito_"+quebra[0]).html());
            dir = parseInt(dir) - parseInt($("#carda_acomp_ocupa_"+qual).attr("value"));
            if(dir>=0){
                preco_total = 0;        
                qtd = parseInt($("#carda_acomp_qtd_"+qual).html());

                if(qtd){
                    qtd += 1;
                }else{
                    qtd = 1;
                }
                
                $("#carda_acomp_qtd_"+qual).html(qtd);

                preco_unitario = parseFloat($("#carda_acomp_preco_"+qual).attr("value"));
                preco_unitario *= qtd;
                
                preco_unitario = number_format(preco_unitario, 2, ',', '.');
                $("#carda_acomp_preco_unitario_"+qual).html("+ R$"+preco_unitario);

                $(".carda_acomp_qtd_"+quebra[0]).each(function(){
                    idadi = $(this).attr("id");
                    idadi = idadi.split("_");
                    idadi = idadi[4];
                    
                    if($(this).html()==""){
                       qtdadi = 0;
                    }else{
                        qtdadi = parseInt($(this).html());
                    }       
                    preco_total += (qtdadi * parseFloat($("#carda_acomp_preco_"+quebra[0]+"_"+idadi).attr("value")));
                });

                if(preco_total==0){
                    $("#carda_acomp_total_"+quebra[0]).html("+ R$0,00");
                }else{
                    preco_total = number_format(preco_total, 2, ',', '.');
                    $("#carda_acomp_total_"+quebra[0]).html("+ R$"+preco_total);
                }

                
                $("#acomp_direito_"+quebra[0]).html(dir);
            }
            
        });
        $(".poe_destaque_acomp").click( function(){
        
            qual = $(this).attr("produto");
            quebra = qual.split("_");
            dir = parseInt($("#acomp_destaque_direito_"+quebra[0]).html());
            dir = parseInt(dir) - parseInt($("#carda_destaque_acomp_ocupa_"+qual).attr("value"));
            if(dir>=0){
                preco_total = 0;        
                qtd = parseInt($("#carda_destaque_acomp_qtd_"+qual).html());

                if(qtd){
                    qtd += 1;
                }else{
                    qtd = 1;
                }
                $("#carda_destaque_acomp_qtd_"+qual).html(qtd);
                
                preco_unitario = parseFloat($("#carda_destaque_acomp_preco_"+qual).attr("value"));
                
                preco_unitario *= qtd;
               
                preco_unitario = number_format(preco_unitario, 2, ',', '.');
                $("#carda_destaque_acomp_preco_unitario_"+qual).html("+ R$"+preco_unitario);

                $(".carda_destaque_acomp_qtd_"+quebra[0]).each(function(){
                    idadi = $(this).attr("id");
                    idadi = idadi.split("_");
                    idadi = idadi[5];
                    
                    if($(this).html()==""){
                       qtdadi = 0;
                    }else{
                        qtdadi = parseInt($(this).html());
                    }
                    
                    
                    preco_total += (qtdadi * parseFloat($("#carda_destaque_acomp_preco_"+quebra[0]+"_"+idadi).attr("value")));
                    
                });

                if(preco_total==0){
                    $("#carda_destaque_acomp_total_"+quebra[0]).html("+ R$0,00");
                }else{
                    preco_total = number_format(preco_total, 2, ',', '.');
                    $("#carda_destaque_acomp_total_"+quebra[0]).html("+ R$"+preco_total);
                }

                
                $("#acomp_destaque_direito_"+quebra[0]).html(dir);
            }
             
        });
        $(".poe_extr").click( function(){
            qual = $(this).attr("produto");
            quebra = qual.split("_");
            
            
                preco_total = 0;        
                qtd = parseInt($("#carda_extr_qtd_"+qual).html());

                if(qtd){
                    qtd += 1;
                }else{
                    qtd = 1;
                }
                $("#carda_extr_qtd_"+qual).html(qtd);
                
                preco_unitario = parseFloat($("#carda_extr_preco_"+qual).attr("value"));
                preco_unitario *= qtd;
                
                preco_unitario = number_format(preco_unitario, 2, ',', '.');
                $("#carda_extr_preco_unitario_"+qual).html("+ R$"+preco_unitario);
                

                $(".carda_extr_qtd_"+quebra[0]).each(function(){
                    idadi = $(this).attr("id");
                    idadi = idadi.split("_");
                    idadi = idadi[4];
                    
                    if($(this).html()==""){
                       qtdadi = 0;
                    }else{
                        qtdadi = parseInt($(this).html());
                    }       
                    preco_total += (qtdadi * parseFloat($("#carda_extr_preco_"+quebra[0]+"_"+idadi).attr("value")));
                });

                if(preco_total==0){
                    $("#carda_extr_total_"+quebra[0]).html("+ R$0,00");
                }else{
                    preco_total = number_format(preco_total, 2, ',', '.');
                    $("#carda_extr_total_"+quebra[0]).html("+ R$"+preco_total);
                }


             
        });
        
        $(".poe_segundo").click( function(){

            qual = $(this).attr("produto");
            quebra = qual.split("_");

            num = 0;
            
            conf2 = $("#carda_sabor_extra_"+quebra[0]+"_2").html();
            conf2 = conf2.split(" ");
            conf2 = conf2.join("");
            <? if($restaurante->qtd_max_sabores>2){ ?>
            conf3 = $("#carda_sabor_extra_"+quebra[0]+"_3").html();
            conf3 = conf3.split(" ");
            conf3 = conf3.join("");
            <? }
                if($restaurante->qtd_max_sabores>3){
            ?>
            conf4 = $("#carda_sabor_extra_"+quebra[0]+"_4").html();
            conf4 = conf4.split(" ");
            conf4 = conf4.join("");
            <? } ?>
            
            if(conf2=="Nenhum"){
                num = 2;
            }else if(conf3=="Nenhum"){
                num = 3;
            }else if(conf4=="Nenhum"){
                num = 4;
            }
            
            nome = $("#carda_sabor_extra_nome_"+qual).html();
            $("#carda_sabor_extra_"+quebra[0]+"_"+num).html(nome);
            
            $("#carda_sabor_extra_id_"+quebra[0]+"_"+num).attr("value",quebra[1]);
            
            preco_unitario = parseFloat($("#carda_sabor_extra_preco_"+qual).attr("value"));
            $("#carda_sabor_extra_preco_incluso_"+quebra[0]+"_"+num).attr("value",preco_unitario);
            
 
  
            preco_total = 0;
            
            limite = <?= $restaurante->qtd_max_sabores - 1 ?>;
            
            for(i=0;i<limite;i++){
                if(preco_total<parseFloat($("#carda_sabor_extra_preco_incluso_"+quebra[0]+"_"+(i+2)).attr("value"))){
                    preco_total = parseFloat($("#carda_sabor_extra_preco_incluso_"+quebra[0]+"_"+(i+2)).attr("value"));
                }
            }
            
            if(preco_total==0){
                $("#carda_sabor_extra_total_"+quebra[0]).html("+ R$0,00");
            }else{
                preco_total = number_format(preco_total, 2, ',', '.');
                $("#carda_sabor_extra_total_"+quebra[0]).html("+ R$"+preco_total);
            }

        });

        $(".fechar_segundosabor").click( function(){
            qual = $(this).attr("produto");
            quebra = qual.split("_");
            
            $(".carda_segundosabor_"+qual).each(function(){
                $(this).hide();
            });
            
            limite = <?= $restaurante->qtd_max_sabores - 1 ?>;
            for(i=0;i<limite;i++){
                $("#carda_sabor_extra_"+quebra[0]+"_"+(i+2)).each(function(){
                    $(this).html("Nenhum");
                });
            }
            
            $(".carda_sabor_extra_preco_incluso"+qual).each(function(){
                $(this).attr("value",0);
            });
            
            $("#carda_sabor_extra_id_"+idprod+"_2").attr("value",0);
            $("#carda_sabor_extra_id_"+idprod+"_3").attr("value",0);
            $("#carda_sabor_extra_id_"+idprod+"_4").attr("value",0);

            $("#carda_sabor_extra_total_"+quebra[0]).html("+ R$ 0,00");
                          
        });
        $(".fechar_acomp").click( function(){
            qual = $(this).attr("produto");
            quebra = qual.split("_");
            
            $(".carda_acomp_"+qual).each(function(){
                $(this).hide();
            });
            
            $(".carda_acomp_qtd_"+qual).each(function(){
                $(this).empty();
            });
            
            $(".carda_acomp_preco_unitario_"+qual).each(function(){
                $(this).empty();
            });
            
            dir = $("#acomp_direito_"+quebra[0]).attr("valor");
            $("#acomp_direito_"+quebra[0]).html(dir);
            $("#carda_acomp_total_"+quebra[0]).html("+ R$ 0,00");
                          
        });
        $(".fechar_destaque_acomp").click( function(){
            qual = $(this).attr("produto");
            quebra = qual.split("_");
            
            $(".carda_destaque_acomp_"+qual).each(function(){
                $(this).hide();
            });
            
            $(".carda_destaque_acomp_qtd_"+qual).each(function(){
                $(this).empty();
            });
            
            $(".carda_destaque_acomp_preco_unitario_"+qual).each(function(){
                $(this).empty();
            });
            
            dir = $("#acomp_destaque_direito_"+quebra[0]).attr("valor");
            $("#acomp_destaque_direito_"+quebra[0]).html(dir);
            $("#carda_destaque_acomp_total_"+quebra[0]).html("+ R$ 0,00");
                          
        });
        $(".fechar_extr").click( function(){
            qual = $(this).attr("produto");
            quebra = qual.split("_");
            
            $(".carda_extr_"+qual).each(function(){
                $(this).hide();
            });
            
            $(".carda_extr_qtd_"+qual).each(function(){
                $(this).empty();
            });
            
            $(".carda_extr_preco_unitario_"+qual).each(function(){
                $(this).empty();
            });
            
            $("#link_extra_"+qual).css("color","#F90");
            $("#link_extra_"+qual).html(" +extras");
            $("#link_extra_"+qual).css("font-size","9px");
            

            $("#carda_extr_total_"+quebra[0]).html("+ R$ 0,00");
                          
        });
        $(".confirmar_extr").click( function(){
            qual = $(this).attr("produto");
            quebra = qual.split("_");
            valor = $("#carda_extr_total_"+quebra[0]).html();
            
            $("#link_extra_"+qual).css("color","#0F0");
            $("#link_extra_"+qual).html(" +extras ("+valor+")");
            $("#link_extra_"+qual).css("font-size","12px");
            
            $(".carda_extr_"+qual).each(function(){
                $(this).hide();
            });
                          
        });
        $(".confirmar_sabor_extra").click( function(){
            qual = $(this).attr("produto");
            quebra = qual.split("_");
            
            $(".carda_segundosabor_"+qual).each(function(){
                $(this).hide();
            });
                          
        });
        $(".mostra_extra").click( function(){
            qual = $(this).attr("produto");

            $(".carda_extr_"+qual).each(function(){
                $(this).show();
            });
        });
        $(".mostra_sabor_extra").click( function(){
            qual = $(this).attr("produto");

            $(".carda_segundosabor_"+qual).each(function(){
                $(this).show();
            });
        });
        
    });
    function destroi_box(x){
        qual = document.getElementById("produto_box_"+x);
        carrinho = document.getElementById("campo_pedido_detalhado");
        carrinho.removeChild(qual);
        
        valor_total = 0;
        taxa_entrega = parseFloat($("#taxa_de_entrega").attr("value"));
 
        vet = getElementByClass("preco_carrinho");
        
        for(var i in vet){
            preco = vet[i].value;
            valor_total += parseFloat(preco);
        }
        
        document.getElementById("subtotal_carrinho").innerHTML = "R$ "+number_format(valor_total, 2, ',', '.');
        document.getElementById("total_carrinho").innerHTML = "R$ "+number_format((valor_total + taxa_entrega), 2, ',', '.'); 
    }
    function passa_etapa(){
        $("#form_carrinho").submit();
    }
    function obter_preco2(x){
        preco = parseFloat(document.getElementById("carda_preco_"+x).value);
        
        precoa = 0;        
        $(".carda_destaque_acomp_qtd_"+x).each(function(){
            qtda = parseInt($(this).html());
            y = $(this).attr("id");
            y = y.split("_");
            y = y[5];
            for(i=0;i<qtda;i++){
                precoa += parseFloat($("#carda_destaque_acomp_preco_"+x+"_"+y).attr("value"));
            }
        });
        
        preco += precoa;
        
        return preco;
        
    }
    function obter_preco(x){
        preco = parseFloat(document.getElementById("carda_preco_"+x).value);
        
        if(parseInt($("#aceita_seg_sab_"+x).attr("value"))){
            m1 = parseFloat($("#carda_sabor_extra_preco_incluso_"+x+"_2").attr("value"));
            acrescimo = m1;
            <? if($restaurante->qtd_max_sabores>2){ ?>
                m2 = parseFloat($("#carda_sabor_extra_preco_incluso_"+x+"_3").attr("value"));
                acrescimo = Math.max(acrescimo,m2);
            <? }
               if($restaurante->qtd_max_sabores>3){
            ?>
               m3 = parseFloat($("#carda_sabor_extra_preco_incluso_"+x+"_4").attr("value"));
               acrescimo = Math.max(acrescimo,m3);
            <?
               }
            ?>

            preco += acrescimo;
        }
        
        precoa = 0;        
        $(".carda_acomp_qtd_"+x).each(function(){
            qtda = parseInt($(this).html());
            y = $(this).attr("id");
            y = y.split("_");
            y = y[4];
            for(i=0;i<qtda;i++){
                precoa += parseFloat($("#carda_acomp_preco_"+x+"_"+y).attr("value"));
            }
        });
        
        $(".carda_extr_qtd_"+x).each(function(){
            qtda = parseInt($(this).html());
            y = $(this).attr("id");
            y = y.split("_");
            y = y[4];
            for(i=0;i<qtda;i++){
                precoa += parseFloat($("#carda_extr_preco_"+x+"_"+y).attr("value"));
            }
        });
        
        preco += precoa;
        
        return preco;
        
    }
    function arruma_destaque_acompanhamentos(idprod){
        counta = 0;
        item_no_carrinho = "";
        $(".carda_destaque_acomp_qtd_"+idprod).each(function(){
            qtda = parseInt($(this).html());

            for(i=0;i<qtda;i++){
              if(counta>0){
                  item_no_carrinho += ", ";
              }
                    item_no_carrinho += "<span style='font-size:10px;' id='span_adi_prod_"+numero+"_"+counta+"'>";
                        idadi = $(this).attr("id");
                        idadi = idadi.split("_");

                        item_no_carrinho += $("#carda_destaque_acomp_nome_"+idadi[4]+"_"+idadi[5]).html();
                        item_no_carrinho += "<input type='hidden' class='adi_prod_nome_"+numero+"' id='adi_prod_nome_"+numero+"_"+counta+"' value='"+$("#carda_destaque_acomp_nome_"+idadi[4]+"_"+idadi[5]).html()+"'>"; 
                        item_no_carrinho += "<input type='hidden'  class='adi_prod_"+numero+"' id='adi_prod_"+numero+"_"+counta+"' name='adi_prod_"+numero+"_"+counta+"' value='"+idadi[5]+"'>";

                    item_no_carrinho += "</span>";

              counta++;
            }  
        });
        return item_no_carrinho;
    }
    function arruma_acompanhamentos(idprod){
        counta = 0;
        item_no_carrinho = "";
        $(".carda_acomp_qtd_"+idprod).each(function(){
            qtda = parseInt($(this).html());

            for(i=0;i<qtda;i++){
              if(counta>0){
                  item_no_carrinho += ", ";
              }
                    item_no_carrinho += "<span style='font-size:10px;' id='span_adi_prod_"+numero+"_"+counta+"'>";
                        idadi = $(this).attr("id");
                        idadi = idadi.split("_");

                        item_no_carrinho += $("#carda_acomp_nome_"+idadi[3]+"_"+idadi[4]).html();
                        item_no_carrinho += "<input type='hidden' class='adi_prod_nome_"+numero+"' id='adi_prod_nome_"+numero+"_"+counta+"' value='"+$("#carda_acomp_nome_"+idadi[3]+"_"+idadi[4]).html()+"'>"; 
                        item_no_carrinho += "<input type='hidden'  class='adi_prod_"+numero+"' id='adi_prod_"+numero+"_"+counta+"' name='adi_prod_"+numero+"_"+counta+"' value='"+idadi[4]+"'>";

                    item_no_carrinho += "</span>";

              counta++;
            }  
        });
        return item_no_carrinho;
    }
    function arruma_extras(idprod){
        counta = 0;
        $(".carda_acomp_qtd_"+idprod).each(function(){
            qtda = parseInt($(this).html());
            for(i=0;i<qtda;i++){
                counta++;
            }
        });
        countb = 0;
        item_no_carrinho = "";
        $(".carda_extr_qtd_"+idprod).each(function(){
            qtda = parseInt($(this).html());

            for(i=0;i<qtda;i++){
              if(countb>0){
                  item_no_carrinho += ", ";
              }
                    item_no_carrinho += "<span style='font-size:10px;' id='span_adi_prod_"+numero+"_"+counta+"'>";
                        idadi = $(this).attr("id");
                        idadi = idadi.split("_");

                        item_no_carrinho += "+"+$("#carda_extr_nome_"+idadi[3]+"_"+idadi[4]).html();
                        item_no_carrinho += "<input type='hidden' class='adi_prod_nome_"+numero+"' id='adi_prod_nome_"+numero+"_"+counta+"' value='"+$("#carda_extr_nome_"+idadi[3]+"_"+idadi[4]).html()+"'>"; 
                        item_no_carrinho += "<input type='hidden'  class='adi_prod_"+numero+"' id='adi_prod_"+numero+"_"+counta+"' name='adi_prod_"+numero+"_"+counta+"' value='"+idadi[4]+"'>";

                    item_no_carrinho += "</span>";

              counta++;
              countb++;
            }  
        });
        return item_no_carrinho;
    }
    function arruma_acompanhamentos2(idprod){
        counta = 0;
        item_no_carrinho = "";
        $(".carda_acomp_qtd_"+idprod).each(function(){
            qtda = parseInt($(this).html());

            for(i=0;i<qtda;i++){
              if(counta>0){
                  item_no_carrinho += ", ";
              }

                        idadi = $(this).attr("id");
                        idadi = idadi.split("_");

                        item_no_carrinho += $("#carda_acomp_nome_"+idadi[3]+"_"+idadi[4]).html();

              counta++;
            }  
        });
        $(".carda_extr_qtd_"+idprod).each(function(){
            qtda = parseInt($(this).html());

            for(i=0;i<qtda;i++){
              if(counta>0){
                  item_no_carrinho += ", ";
              }

                        idadi = $(this).attr("id");
                        idadi = idadi.split("_");

                        item_no_carrinho += $("#carda_extr_nome_"+idadi[3]+"_"+idadi[4]).html();

              counta++;
            }  
        });
        return item_no_carrinho;
    }
    function arruma_acompanhamentos3(idprod){
        counta = 0;
        item_no_carrinho = "";
        $(".carda_destaque_acomp_qtd_"+idprod).each(function(){
            qtda = parseInt($(this).html());

            for(i=0;i<qtda;i++){
              if(counta>0){
                  item_no_carrinho += ", ";
              }

                        idadi = $(this).attr("id");
                        idadi = idadi.split("_");

                        item_no_carrinho += $("#carda_destaque_acomp_nome_"+idadi[4]+"_"+idadi[5]).html();

              counta++;
            }  
        });
        return item_no_carrinho;
    }
    function confere_se_id_e_igual(x,y){
        resposta = 1;

            v1 = x.split("/");
            v1.sort();
           
            
            var v2 = new Array();
            v2[0] = y;
            if(parseInt($("#carda_sabor_extra_id_"+y+"_2").attr("value"))){
                v2[1] = $("#carda_sabor_extra_id_"+y+"_2").attr("value");
                if(parseInt($("#carda_sabor_extra_id_"+y+"_3").attr("value"))){
                    v2[2] = $("#carda_sabor_extra_id_"+y+"_3").attr("value");
                    if(parseInt($("#carda_sabor_extra_id_"+y+"_4").attr("value"))){
                        v2[3] = $("#carda_sabor_extra_id_"+y+"_4").attr("value");
                    }
                }
            }

            v2.sort();

            if(v1.length==v2.length){
                for(i=0;i<v1.length;i++){
                    if(v1[i]!=v2[i]){
                        resposta = 0;
                    }
                }
            }else{
                resposta = 0;
            }
           
        
        return resposta;
    }
    function confere_se_acomp_e_igual(x,y,z){
        resposta = 0;
        
        acomps1 = "";
        acomps2 = "";
        
        if(z=="normal"){
            acomps1 = arruma_acompanhamentos2(y);
        }else{
            acomps1 = arruma_acompanhamentos3(y);
        }
        c = 0;
        
        apn = getElementByClass("adi_prod_nome_"+x);
        for(var i in apn){
            if(c==0){
                acomps2 += apn[i].value;
            }else{
                acomps2 += " , "+apn[i].value;
            }
            c++;
        }
        
        acomps1 = acomps1.split(" ");
        acomps1 = acomps1.join("");
        
        acomps2 = acomps2.split(" ");
        acomps2 = acomps2.join("");
        
        if(acomps1==acomps2){
            resposta = 1;
        }
        
        return resposta;
    }
    function show(x){
	oque = document.getElementById(x);
	if(oque.style.display=='block'){
	    oque.style.display = "none";
	}else{
	    oque.style.display = "block";
	}
    }
    function check_show(x,y){
    
	oque = document.getElementById(y);
	oque2 = document.getElementById(x);

	if(oque.checked){
	    oque2.style.display = "block";
	}else{
	    oque2.style.display = "none";
	}
    }
    function erase(x){
	oque = document.getElementById(x);
	oque.value = "";
    }
    function mais(x){
	oque = document.getElementById(x);
	oque.value = parseInt(oque.value) + 1;
    }
    function menos(x){
	oque = document.getElementById(x);
	if(oque.value>1){
	    oque.value = parseInt(oque.value) - 1;
	}
    }

</script>

<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/s3Slider.js" type="text/javascript"></script>
<script>

    

    $(document).ready(function(){  
	left_car=0;
	retorno_car=0;
	if(screen.width==1024){
	    $("#carrinho").css("left","88.5%");
	    left_car="88.5%";
	    retorno_car="67.5%"; 
	}
	else if(screen.width==1280){
	    $("#carrinho").css("left","91%");
	    left_car="91%";
	    retorno_car="74.1%"; 
	}
	else if(screen.width==1366){
	    $("#carrinho").css("left","91.5%");
	    left_car="91.5%";
	    retorno_car="75.8%"; 
	}
	else if(screen.width==320){
	    $("#carrinho").css("left","88.5%");
	    left_car="88.5%";
	    retorno_car="67.5%"; 
	}
	else{
	    $("#carrinho").css("left","91.5%");
	    left_car="91.5%";
	    retorno_car="75.8%"; 
	}
	//Horizontal Sliding 
	  
	$('#movi').hover(function(){  
	    $("#carrinho").stop().animate({left:retorno_car},{queue:false,duration:300});  
	}, function() {  
	    $("#carrinho").stop().animate({left:left_car},{queue:false,duration:300});  
	});  
  
    });  

</script>    

<?php if($_SESSION['usuario']){
        include "menu_user.php";
    }else{
        include "menu2.php"; 
    } ?>
<div id="central" class="span-24">
    <div class="span-6">
	<div id="barra_esquerda">
	    <div id="info_restaurante">
   
                <div id="categoria_rest"><?= $restaurante->getNomeCategoria() ?>
                </div>
                <div id="nome_rest"><?= $restaurante->nome ?>
                </div>
                <div id="avatar_rest">
                    <img src="images/restaurante/<?= $restaurante->imagem ?>">
                </div>

		<div id="formas_pagamento"> 
        <span class="tool">&nbsp;Formas de pagamento
                <?
                     $width = sizeof($restaurante->restaurante_pagamentos) * 42;
                        if($width>140){
                            $width = 140;
                        }
                ?>
                        <span class="tip" style="background:#EEE; width:<?= $width ?>px">
		    <? $fps = RestauranteAceitaFormaPagamento::all(array("conditions" => array("restaurante_id=?", $restaurante->id)));
		    if ($fps) { ?>
            
    		    
				<? foreach ($fps as $fp) { ?>
                <img src="background/<?= $fp->forma_pagamento->url ?>" style="margin-left:3px" title="<?= $fp->forma_pagamento->nome ?>">					
				<? } ?>
    			
		    <? } ?>

</span></span>
		</div>
		<div id="tempo_entrega">Tempo de entrega:<img src="background/relogio.gif" width="20" height="19" style="position:relative; top:6px; left:4px;">&nbsp;&nbsp;&nbsp;<?
		    
                        echo $rxb->tempo_entrega . "min";
			
		    ?> 
		</div>
	    </div>
	    <div id="filtro" class="prepend-top">
		<img src="background/titulo_filtro.gif" width="74" height="26" alt="Filtro" style="margin-left:25px">
                
		    <div style="padding-top:5px;">
			<div style="color:#CC0000; padding-top:5px; padding-left:12px;">
			    <?
			    if($categorias) {
				foreach($categorias as $categoria) {
                                   $num=0;
                                   $produtos = Produto::find_by_sql("SELECT P.* FROM produto P INNER JOIN produto_tem_tipo PTT ON P.id = PTT.produto_id WHERE PTT.tipoproduto_id = " . $categoria->tipo_produto->id . " AND ativo = 1 AND disponivel = 1 AND P.restaurante_id = " . $_GET['id']);
                                   $num=sizeof($produtos);
			    ?>
			    <div style="color:#CC0000; padding-top:5px; padding-left:12px;">
				<input type="checkbox" class="refino filtro_categoria" id="checkrest_<?= $categoria->tipo_produto->id ?>" value="<?= $categoria->tipo_produto->id ?>" /> &nbsp; <?= $categoria->tipo_produto->nome ?> (<?= $num ?>)
			    </div>
			    <? } } ?>
			</div>
		    </div>
		
	    </div>	


	</div>
    </div>
    <div class="span-18 last">

	<div class="prepend-top" id="status">
	    <div id="numero_rest" style="color:#FFF" ><span style="margin-left:8px;"> </span>
	    </div> 
	    <div id="status_pedido">
		<img src="background/passo2.png" alt="passo1" width="541" height="43" border="0" usemap="#Map">
<map name="Map" id="Map"><area shape="rect" coords="2,1,131,42" href="restaurantes" /></map>
	    </div>
	</div>
	<div id="titulo_box_destaque" >
	    Dicas du Chef
	</div>






	<div id="box_destaque" class="radios" >
	    <?
	    $destaques = Produto::find_by_sql("SELECT * FROM produto WHERE destaque=1 AND ativo=1 AND disponivel = 1 AND restaurante_id =".$restaurante->id." ORDER BY rand() LIMIT 3");
	    if ($destaques) {
		$c = 1;
		foreach ($destaques as $dest) {
		    ?>
		    <div class="destaque" <? if ($c == 2) {
			echo "style='margin:0 16px;'";
		    } ?> >
			<div class="avatar_destaque">
                            <? if($dest->imagem!=""){ ?>
                            <img  src="images/produto/<?= $dest->imagem ?>" >
                            <? } ?>    
			</div>
			<div class="titulo_destaque">
			    <?= $dest->nome ?>
                            <?= $dest->tamanho ? $dest->tamanho : "" ?>
			</div>
			<div class="descricao_destaque">
	<?= $dest->descricao ?>
                            <? if($dest->esta_em_promocao){ ?>
                            <div style="color:#F70;"><?= $dest->texto_promocao ?></div>
                            <? } ?>
			</div>
			<div class="preco_destaque">
                                
                            <? if($dest->esta_em_promocao){ ?>
                                <span style="text-decoration: overline;"><?= StringUtil::doubleToCurrency($dest->preco_promocional); ?></span>&nbsp;&nbsp;
                                <span style="color:#666; font-size:10px; text-decoration: line-through;"><?= StringUtil::doubleToCurrency($dest->preco); ?></span>
                            <? }else{ ?>
                                <span style="text-decoration: overline;"><?= StringUtil::doubleToCurrency($dest->preco); ?></span>
                            <? } ?>
                                
			    <img src="background/botao_add.gif" class="poe_destaque_carrinho" quemsou="botao_add" produto="<?= $dest->id ?>" width="36" height="30" style="float:left; cursor:pointer;" /> 
			</div>
                        <? 
                            $tem_acomp = 0;
                            if($dest->produto_tem_produtos_adicionais){
                                foreach($dest->produto_tem_produtos_adicionais as $aaa){
                                    if(($aaa->produto_adicional->quantas_unidades_ocupa>0)&&($aaa->produto_adicional->ativo==1)&&($aaa->produto_adicional->disponivel==1)){
                                        $tem_acomp = 1;
                                    }
                                }
                            }
                            if($tem_acomp){ 
                                
                                ?>
                    
                            <div class="carda_destaque_acomp_<?= $dest->id ?> pop-follow" style="position:absolute; z-index:10; display:none;">
                                <img src="background/logo_noback.png" height="48" width="46" style="position:absolute; top:2px; left:4px; z-index:2; "> <img class="fechar_destaque_acomp"  produto="<?= $dest->id ?>" src="background/close.png" height="22" width="22" style="position:absolute; top:6px; right:3px; z-index:2; cursor:pointer;">
                                        <div style="width:264px; position:relative; float:left; margin:8px 0; background:#F4F4F4;">
                                  <div class="titulo_follow">Acompanhamentos</div>
                                  </div>
                                  <table style="background:#F4F4F4; font-size:12px; width:264px; color:#999; float:left; position:relative; margin-top:10px;">

                                    <? foreach($dest->produto_tem_produtos_adicionais as $aaa){ 
                                        if(($aaa->produto_adicional->quantas_unidades_ocupa>0)&&($aaa->produto_adicional->ativo==1)&&($aaa->produto_adicional->disponivel==1)){
                                        ?>





                                                    <input type="hidden" class="carda_destaque_acomp_preco_<?= $dest->id ?>" id="carda_destaque_acomp_preco_<?= $dest->id ?>_<?= $aaa->produto_adicional->id ?>" value="<?= $aaa->produto_adicional->preco_adicional ?>">
                                                    <input type="hidden" id="carda_destaque_acomp_ocupa_<?= $dest->id ?>_<?= $aaa->produto_adicional->id ?>" value="<?= $aaa->produto_adicional->quantas_unidades_ocupa ?>">
                                                    <tr>
                                                      <td><img src="background/botao_add.gif" height="16" width="20" class="poe_destaque_acomp" produto="<?= $dest->id ?>_<?= $aaa->produto_adicional->id ?>" style="cursor:pointer;" /></td>
                                                      <td id="carda_destaque_acomp_nome_<?= $dest->id ?>_<?= $aaa->produto_adicional->id ?>"><?= $aaa->produto_adicional->nome ?> </td>
                                                      <td class="carda_destaque_acomp_qtd_<?= $dest->id ?>" id="carda_destaque_acomp_qtd_<?= $dest->id ?>_<?= $aaa->produto_adicional->id ?>"></td>
                                                      <td class="carda_destaque_acomp_preco_unitario_<?= $dest->id ?>" id="carda_destaque_acomp_preco_unitario_<?= $dest->id ?>_<?= $aaa->produto_adicional->id ?>"></td>
                                                      <td></td> 
                                                      <td></td>
                                                    </tr>



                                <? }} ?>
                                        <tr>
                                      <td></td>
                                      <td  colspan="1" style="color:#E51B21;">Total</td>
                                      <td></td>
                                      <td id="carda_destaque_acomp_total_<?= $dest->id ?>" colspan="2" style="color:#E51B21; font-size:9px;">+ R$0,00</td>
                                      <td></td>
                                        </tr>
                                    <tr>
                                        <td></td>
                                    </tr>
                                     <tr>
                                        <td></td>
                                    </tr>
                                    <tr>
                                      <td colspan="6" style="color:#F90; text-align:center;">Voc&ecirc; tem direito a <span id="acomp_destaque_direito_<?= $dest->id ?>" valor="<?= $dest->qtd_produto_adicional ?>"><?= $dest->qtd_produto_adicional ?></span> por&ccedil;&otilde;es</td>
                                        </tr>
                                    <tr>
                                        <td colspan="6" style="text-align:center;"><img class="poe_destaque_carrinho" quemsou="botao_add_acomp" style="cursor:pointer" produto="<?= $dest->id ?>" src="background/concluir.png"></td>
                                    </tr>
                                </table>

                            </div>
                            <? }  ?>
		    </div>
		<?
		$c++;
	    }
	}
	?>                     
	</div>                

<?
$categorias = TipoProduto::find_by_sql("SELECT TP.* FROM tipo_produto TP INNER JOIN restaurante_tem_tipo_produto RTTP ON TP.id = RTTP.tipoproduto_id WHERE RTTP.restaurante_id = " . $_GET['id']." ORDER BY ordem");
if ($categorias) {
    foreach ($categorias as $cat) {
        $catmur = RestauranteTemTipoProduto::find(array("conditions"=>array("tipoproduto_id = ? AND restaurante_id = ?",$cat->id,$_GET['id'])));
	?>  <div id="box_box_categoria_<?= $cat->id ?>">
		<div class="titulo_box_categoria"><?= $cat->nome ?>
                    <? if($catmur->mural!=""){ ?>
                        <span style="font-size:9px;">*<?= $catmur->mural ?></span>
                    <? } ?>
		</div>

		<div id="box_categoria" class="radios" >
		    <?
		    $produtos = Produto::find_by_sql("SELECT P.* FROM produto P INNER JOIN produto_tem_tipo PTT ON P.id = PTT.produto_id WHERE PTT.tipoproduto_id = " . $cat->id . " AND ativo = 1 AND disponivel = 1 AND P.restaurante_id = " . $_GET['id']." ORDER BY ordem");
		    if ($produtos) {
			$c = 1;
                        $maior=0;
                        $menor=0;
			foreach ($produtos as $prod) {
                            if($prod->tamanho!=""){
                                
                                $irmaos=Produto::all(array("order"=>"preco desc","conditions"=>array("nome = ? AND ativo = ? AND disponivel = ? AND restaurante_id = ?",$prod->nome,1,1,$_GET['id'])));
                                if($irmaos){
                                    if($irmaos[0]->id==$prod->id){
                                        $irmao_maior = 1;
                                        foreach($irmaos as $key=>$irmao){
                                            if($key>0){
                                                $maior = $irmaos[$key-1]->id;
                                            }else{
                                                $maior = 0;
                                            }
                                            if($key<sizeof($irmaos)-1){
                                                $menor = $irmaos[$key+1]->id;
                                            }else{
                                                $menor = 0;
                                            }
                                            if($irmao_maior==1){
                                                $display = 1;
                                                $irmao_maior = 0;
                                            }else{
                                                $display = 0;
                                            }
                                            echo invoca_produto($irmao,$c,$display,$menor,$maior);
                                            
                                        }
                                    }
                                }
                                
                                $c++;
                            }else{
                                $display = 1;
                                echo invoca_produto($prod,$c,$display,$menor,$maior);
                                $c++;
                            }
                        }
		    }
		
		?>
		</div>
        </div>
    <? }
} ?> 





    </div>
</div>
<form id="form_carrinho" action="" method="post">
    <input type="hidden" name="action" id="action" value="finaliza_carrinho">
<?php include "carrinho.php" ?>
</form>
<? if($mensagem_fechado){ ?>
<script>
    $(function() {
        $("body").delay(1000,function(){
            alert("Desculpe, este restaurante est\u00e1 fechado ou fora do ar.");
        });
    });
</script>
<? } ?>
<? include("include/footer.php"); ?>