<?php
	$plazasLink = array(
		"1" => "torreon",
		"2" => "monterrey",
		"3" => "chihuahua",
		"4" => "leon",
		"5" => "queretaro"
	);

	$plazas = array(
		"0" => "Corporativo", 
		"1" => "Torreón",
		"2" => "Monterrey",
		"3" => "Chihuahua",
		"4" => "León",
		"5" => "Querétaro"
	);

	$plazasUpper = array(
		"0" => "CORPORATIVO", 
		"1" => "TORREÓN",
		"2" => "MONTERREY",
		"3" => "CHIHUAHUA",
		"4" => "LEÓN",
		"5" => "QUERÉTARO"
	);

	$meses = array(	
		"1" => "Enero",
		"2" => "Febrero",
		"3" => "Marzo",
		"4" => "Abril",
		"5" => "Mayo",
		"6" => "Junio",
		"7" => "Julio",
		"8" => "Agosto",
		"9" => "Septiembre",
		"10" => "Octubre",
		"11" => "Noviembre",
		"12" => "Diciembre"
	);

	$ciudadesUpper = array(
		"0" => "TODAS", 
		"1" => "TORREÓN",
		"2" => "MONTERREY",
		"3" => "CHIHUAHUA",
		"4" => "LEÓN",
		"5" => "QUERÉTARO"
	);

	$instagram = array(
		"0" => "playersoflife", 
		"1" => "players_torreon",
		"2" => "playersmty",
		"3" => "playerschih",
		"4" => "players_leon",
		"5" => "players_qro"
	);

	$twitter = array(
		"0" => "playersoflife", 
		"1" => "playerstorreon",
		"2" => "players_mty",
		"3" => "playerschih",
		"4" => "players_leon",
		"5" => "players_qro"
	);

	$facebook = array(
		"0" => "playersoflife", 
		"1" => "players.torreon",
		"2" => "players.mty",
		"3" => "players.chih",
		"4" => "players.leon",
		"5" => "players.qro"
	);


	function getPlaza($index){
		global $plazas;
		return $plazas[$index];
	}

	function getPlazaUpper($index){
		global $plazasUpper;
		return $plazasUpper[$index];
	}

	function getPlazaLink($index){
		global $plazasLink;
		return $plazasLink[$index];
	}
	
	function getMes($index){
		global $meses;
		return $meses[$index];
	}

	function dirCount($dir) {
	  $directory = new DirectoryIterator($dir);
	  foreach($directory as $file ){
		  $x++;
		}
	}
	
	function recurse_copy($src,$dst){ 
	    $dir = opendir($src); 
	    @mkdir($dst); 
	    while(false !== ( $file = readdir($dir)) ) { 
	        if (( $file != '.' ) && ( $file != '..' )) { 
	            if ( is_dir($src . '/' . $file) ) { 
	                recurse_copy($src . '/' . $file,$dst . '/' . $file); 
	            } 
	            else { 
	                copy($src . '/' . $file,$dst . '/' . $file); 
	            } 
	        } 
	    } 
	    closedir($dir); 
	}
	
	function rrmdir($dir){
		if (is_dir($dir)){
		 $objects = scandir($dir);
		 foreach ($objects as $object) {
		   if ($object != "." && $object != "..") {
		     if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
		   }
		 }
		 reset($objects);
		 rmdir($dir);
		}
	} 	
?>