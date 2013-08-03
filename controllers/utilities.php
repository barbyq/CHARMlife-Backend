<?php
	$plazas = array(
		"0" => "Corporativo", 
		"1" => "Torreón",
		"2" => "Monterrey",
		"3" => "Chihuahua",
		"4" => "León",
		"5" => "Queretaro"
	);

	function getMes($mes)
	{
		$parsed = intval($mes);
		switch ($parsed) {
			case 1:
  				return 'Enero';
		        	break;
		  	case 2:
		        	return 'Febrero';
		        	break;
		  	case 3:
		  		return 'Marzo';
		  		break;
		  	case 4:
		  		return 'Abril';
		  		break;
		  	case 5:
		  		return 'Mayo';
		  		break;
		  	case 6:
		  		return 'Junio';
		  		break;
		  	case 7:
		  		return 'Julio';
		  		break;
		  	case 8:
		  		return 'Agosto';
		  		break;
		  	case 9:
		  		return 'Septiembre';
		  		break;
		  	case 10:
		  		return 'Octubre';
		  		break;
		  	case 11:
		  		return 'Noviembre';
		  		break;
		  	case 12:
		  		return 'Diciembre';
		  		break;
		}
	}

	function getPlaza($index){
		global $plazas;
		return $plazas[$index];
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

	function garbageeraser($directori)
	{
		$archivos = scandir($directori);
		foreach ($archivos as $archi) {
			print_r("borrando ".$archi);
			$extension = pathinfo($archi);
			switch ($extension['extension']) {
				case 'jpg':
					print_r($archi);
					break;
				case 'png':
					print_r($archi);
					break;
				case 'jpeg':
					print_r($archi);
					break;
				default:
					print_r('borre: ');
					print_r($archi);
					unlink($directori."/".$archi);
					break;
			}
		}
	}

	function checkForImageArticulo($idarticulo)
	{
		$eldirectorio = "";
		$directorio = "/charmadmin/Imagenes/";
		print_r($directorio.$idarticulo);
		if (is_dir($directorio.$idarticulo)) {
			$archivos = scandir($directorio.$idarticulo);
			$eldirectorio = $archivos[2];
		}else{
			$eldirectorio = "";
		}
		return $eldirectorio;
	}

	function rmdir_recurse($path) {
	    $path = rtrim($path, '/').'/';
	    $handle = opendir($path);
	    while(false !== ($file = readdir($handle))) {
	        if($file != '.' and $file != '..' ) {
	            $fullpath = $path.$file;
	            if(is_dir($fullpath)) rmdir_recurse($fullpath); else unlink($fullpath);
	        }
	    }
	    closedir($handle);
	    rmdir($path);
	}

?>