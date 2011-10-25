<?php
///////////////////////////////////////////////////////////////////FUNCOES GERAIS
function connect(){


	$host = "localhost";
	$database = "menuduchef";
	$login = "root";
	$pswd = "chefpass";
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
function detecta_perigo($a){ //acrescente mais caracteres depois
	$sim = 0;	
	
	if(stristr($a,",")){
		$sim = 1;
	}
	if(stristr($a,"\\")){
		$sim = 1;
	}
	if(stristr($a,"--")){
		$sim = 1;
	}
	if(stristr($a,";")){
		$sim = 1;
	}
	if(stristr($a,":")){
		$sim = 1;
	}
	if(stristr($a,"\"")){
		$sim = 1;
	}
	if(stristr($a,"'")){
		$sim = 1;
	}

	return $sim;
}
function detecta_perigo2($a){ //acrescente mais caracteres depois, aqui é para campos como: Endereco, onde eh necessario ter virgulas
	$sim = 0;	
	
	if(stristr($a,"\\")){
		$sim = 1;
	}
	if(stristr($a,"--")){
		$sim = 1;
	}
	if(stristr($a,";")){
		$sim = 1;
	}
	if(stristr($a,":")){
		$sim = 1;
	}
	if(stristr($a,"\"")){
		$sim = 1;
	}
	if(stristr($a,"'")){
		$sim = 1;
	}

	return $sim;
}

?>