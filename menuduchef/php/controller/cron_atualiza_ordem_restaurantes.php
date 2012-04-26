<?php
function connect(){
	$host = "mysql.gleycetour.com.br";
	$database = "restaurante_biro";
	$login = "biroadmin";
	$pswd = "oribdesign";
	$r = FALSE;
	
	if ($con = mysql_connect($host,$login,$pswd))
	{
		if ($sel = mysql_select_db($database,$con))
		{
			$r = $con;
		}
	}
	return $r;
}
//include("../lib/connect_p.php"); tava dando pau na cron o.O
connect();

$r=mysql_query("SELECT * FROM restaurante WHERE ativo = 1");
if($r){
 while($sql=mysql_fetch_array($r)){
  $v[]=$sql['id'];
 }   
 shuffle($v);
 for($i=0;$i<sizeof($v);$i++){
  mysql_query("UPDATE restaurante SET ordem = ".$i." WHERE id = ".$v[$i]);
 }
}
mysql_close();
?>
