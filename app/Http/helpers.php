<?php
	
	//default definitions...
	define('DS', DIRECTORY_SEPARATOR);

	//set default timezone....
	date_default_timezone_set('UTC');


	 function pr($ar, $bool=false){
	 	echo '<pre>';
	 	print_r($ar);
	 	echo '</pre>';
	 	if($bool){
	 		exit;
	 	}
	 }

	 function getArrayObj($ar, $indx){
	 	$ar = unserialize($ar);
	 	return $ar[$indx];
	 }


	 function getServices($ar){
	 	$r = unserialize($ar);
	 	$txt = '';
	 	$ct = 1;
	 	foreach($r as $serv){
	 		$txt .= $serv;
	 		if($ct < count($r)){
	 			$txt .= ', ';
	 		} 
	 		$ct++;
	 	}
	 	return $txt;
	 }

	 function strData($dt){
		 	return number_format($val, 2, ".", ",") ;
	 }

	 function mkDate($dtx){
	 	return date("M j,Y", strtotime($dtx));

	 }

	 /////////////////////////////////atk helpers...

	 function trimTxt($txt){
	 	if(strlen(strval($txt)) > 20){
		 	$txt = substr($txt, 0, 20) . '...';
		 }
		 return $txt;
	 }