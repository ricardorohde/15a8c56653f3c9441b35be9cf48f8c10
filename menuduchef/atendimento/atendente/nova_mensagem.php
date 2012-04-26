<?php

include '../../adm/functions.php';

connect();
$sql="SELECT * FROM mural WHERE aprovado = '0' AND deletado = '0'";
$sql=mysql_query($sql);
mysql_close();

$mural="";
if($mu=mysql_fetch_array($sql)){
	$mural="*H&aacute; novos depoimentos para o mural aguardando aprova&ccedil;&atilde;o!*";
	
}

/*
while($mu=mysql_fetch_array($sql)){
	$mural.="<div style='background:#66AAFF; margin:5px; padding:5px;'>";
	$mural.="<div style='background:#4466CC; '>".$mu['quem']."</div>";
	$mural.="<div style='background:#4466CC; margin-top:5px;'>".$mu['mensagem']."</div>";
	$mural.="<div margin-top:5px;'><input type='submit' name='ir' id='ir' value='Aceitar'><input type='button' name='ir' id='ir' value='Excluir'></div>";
	$mural.="</div>";
}*/

?>
<div style='text-align:center;'><img  src="../../adm/background/logo_biro.gif">
</div>
<div style='text-align:center;'><br/><input type='button' value='Abrir ADM' onclick="window.open('../../adm/index.php')">
</div>
<div style='text-align:center; color:#000066; font-family:arial; font-size:10px;'>

<?php
	echo $mural;
?></div>