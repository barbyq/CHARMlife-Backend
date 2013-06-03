<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

include '../dbc/dbconnect.php';
include 'utilities.php';

if (isset($_POST['receiver']) && $_POST['receiver'] == "primera") {
		$generado = $_POST['generado'];
		print_r($_FILES['primera']["type"]);
		if (is_dir('../TemporalAmigos/'.$generado)) {
			rmdir_recurse('../TemporalAmigos/'.$generado);
			mkdir('../TemporalAmigos/'.$generado);
			if ($_FILES['primera']['type'] ==='image/jpeg') {
				move_uploaded_file($_FILES['primera']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.jpg');
			}else{
				move_uploaded_file($_FILES['primera']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.png');
			}		
		}else{
			mkdir('../TemporalAmigos/'.$generado);
			if ($_FILES['primera']['type'] ==='image/jpeg') {
				move_uploaded_file($_FILES['primera']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.jpg');
			}else{
				move_uploaded_file($_FILES['primera']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.png');
			}
		}
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "segunda") {
	$generado = $_POST['generado'];
		print_r($_FILES['segunda']["type"]);
		if (is_dir('../TemporalAmigos/'.$generado)) {
			rmdir_recurse('../TemporalAmigos/'.$generado);
			mkdir('../TemporalAmigos/'.$generado);
			if ($_FILES['segunda']['type'] ==='image/jpeg') {
				move_uploaded_file($_FILES['segunda']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.jpg');
			}else{
				move_uploaded_file($_FILES['segunda']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.png');
			}		
		}else{
			mkdir('../TemporalAmigos/'.$generado);
			if ($_FILES['segunda']['type'] ==='image/jpeg') {
				move_uploaded_file($_FILES['segunda']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.jpg');
			}else{
				move_uploaded_file($_FILES['segunda']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.png');
			}
		}
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "tercera") {
	$generado = $_POST['generado'];
		print_r($_FILES['tercera']["type"]);
		if (is_dir('../TemporalAmigos/'.$generado)) {
			rmdir_recurse('../TemporalAmigos/'.$generado);
			mkdir('../TemporalAmigos/'.$generado);
			if ($_FILES['tercera']['type'] ==='image/jpeg') {
				move_uploaded_file($_FILES['tercera']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.jpg');
			}else{
				move_uploaded_file($_FILES['tercera']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.png');
			}		
		}else{
			mkdir('../TemporalAmigos/'.$generado);
			if ($_FILES['tercera']['type'] ==='image/jpeg') {
				move_uploaded_file($_FILES['tercera']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.jpg');
			}else{
				move_uploaded_file($_FILES['tercera']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.png');
			}
		}
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "cuarta") {
	$generado = $_POST['generado'];
		print_r($_FILES['cuarta']["type"]);
		if (is_dir('../TemporalAmigos/'.$generado)) {
			rmdir_recurse('../TemporalAmigos/'.$generado);
			mkdir('../TemporalAmigos/'.$generado);
			if ($_FILES['cuarta']['type'] ==='image/jpeg') {
				move_uploaded_file($_FILES['cuarta']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.jpg');
			}else{
				move_uploaded_file($_FILES['cuarta']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.png');
			}		
		}else{
			mkdir('../TemporalAmigos/'.$generado);
			if ($_FILES['cuarta']['type'] ==='image/jpeg') {
				move_uploaded_file($_FILES['cuarta']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.jpg');
			}else{
				move_uploaded_file($_FILES['cuarta']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.png');
			}
		}
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "quinta") {
	$generado = $_POST['generado'];
		print_r($_FILES['quinta']["type"]);
		if (is_dir('../TemporalAmigos/'.$generado)) {
			rmdir_recurse('../TemporalAmigos/'.$generado);
			mkdir('../TemporalAmigos/'.$generado);
			if ($_FILES['quinta']['type'] ==='image/jpeg') {
				move_uploaded_file($_FILES['quinta']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.jpg');
			}else{
				move_uploaded_file($_FILES['quinta']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.png');
			}		
		}else{
			mkdir('../TemporalAmigos/'.$generado);
			if ($_FILES['quinta']['type'] ==='image/jpeg') {
				move_uploaded_file($_FILES['quinta']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.jpg');
			}else{
				move_uploaded_file($_FILES['quinta']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.png');
			}
		}
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "sexta") {
	$generado = $_POST['generado'];
		print_r($_FILES['sexta']["type"]);
		if (is_dir('../TemporalAmigos/'.$generado)) {
			rmdir_recurse('../TemporalAmigos/'.$generado);
			mkdir('../TemporalAmigos/'.$generado);
			if ($_FILES['sexta']['type'] ==='image/jpeg') {
				move_uploaded_file($_FILES['sexta']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.jpg');
			}else{
				move_uploaded_file($_FILES['sexta']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.png');
			}		
		}else{
			mkdir('../TemporalAmigos/'.$generado);
			if ($_FILES['sexta']['type'] ==='image/jpeg') {
				move_uploaded_file($_FILES['sexta']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.jpg');
			}else{
				move_uploaded_file($_FILES['sexta']['tmp_name'],'../TemporalAmigos/'.$generado.'/'.$generado.'.png');
			}
		}
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "registrar") {
	$primera = $_POST['primera'];
	$segunda =  $_POST['segunda'];
	$tercera = $_POST['tercera'];
	$cuarta =	$_POST['cuarta'];
	$quinta = $_POST['quinta'];
	$sexta  = $_POST['sexta'];

	if (is_dir("../TemporalAmigos/".$primera)) {
		$archivos = scandir("../TemporalAmigos/".$primera);
		$terminacion = substr($archivos[2], -3);
		
		$archivosants = scandir("../Amigos/");
		for ($i=2; $i < count($archivosants); $i++) { 
			if (strpos($archivosants[$i],'1') !== false) {
				unlink("../Amigos/".$archivosants[$i]);	
			}
		}
		if (copy("../TemporalAmigos/".$primera."/".$archivos[2],"../Amigos/1.".$terminacion)) {
			rmdir_recurse("../TemporalAmigos/".$primera);
		}
	}

		if (is_dir("../TemporalAmigos/".$segunda)) {
			$archivos = scandir("../TemporalAmigos/".$segunda);
			$terminacion = substr($archivos[2], -3);
			
			$archivosants = scandir("../Amigos/");
			for ($i=2; $i < count($archivosants); $i++) { 
				if (strpos($archivosants[$i],'2') !== false) {
					unlink("../Amigos/".$archivosants[$i]);	
				}
			}
			if (copy("../TemporalAmigos/".$segunda."/".$archivos[2],"../Amigos/2.".$terminacion)) {
				rmdir_recurse("../TemporalAmigos/".$segunda);
			}
		}

			if (is_dir("../TemporalAmigos/".$tercera)) {
				$archivos = scandir("../TemporalAmigos/".$tercera);
				$terminacion = substr($archivos[2], -3);
				
				$archivosants = scandir("../Amigos/");
				for ($i=2; $i < count($archivosants); $i++) { 
					if (strpos($archivosants[$i],'3') !== false) {
						unlink("../Amigos/".$archivosants[$i]);	
					}
				}
				if (copy("../TemporalAmigos/".$tercera."/".$archivos[2],"../Amigos/3.".$terminacion)) {
					rmdir_recurse("../TemporalAmigos/".$tercera);
				}
			}

				if (is_dir("../TemporalAmigos/".$cuarta)) {
					$archivos = scandir("../TemporalAmigos/".$cuarta);
					$terminacion = substr($archivos[2], -3);
					
					$archivosants = scandir("../Amigos/");
					for ($i=2; $i < count($archivosants); $i++) { 
						if (strpos($archivosants[$i],'4') !== false) {
							unlink("../Amigos/".$archivosants[$i]);	
						}
					}
					if (copy("../TemporalAmigos/".$cuarta."/".$archivos[2],"../Amigos/4.".$terminacion)) {
						rmdir_recurse("../TemporalAmigos/".$cuarta);
					}
				}

					if (is_dir("../TemporalAmigos/".$quinta)) {
						$archivos = scandir("../TemporalAmigos/".$quinta);
						$terminacion = substr($archivos[2], -3);
						
						$archivosants = scandir("../Amigos/");
						for ($i=2; $i < count($archivosants); $i++) { 
							if (strpos($archivosants[$i],'5') !== false) {
								unlink("../Amigos/".$archivosants[$i]);	
							}
						}
						if (copy("../TemporalAmigos/".$quinta."/".$archivos[2],"../Amigos/5.".$terminacion)) {
							rmdir_recurse("../TemporalAmigos/".$quinta);
						}
					}

						if (is_dir("../TemporalAmigos/".$sexta)) {
							$archivos = scandir("../TemporalAmigos/".$sexta);
							$terminacion = substr($archivos[2], -3);
							
							$archivosants = scandir("../Amigos/");
							for ($i=2; $i < count($archivosants); $i++) { 
								if (strpos($archivosants[$i],'6') !== false) {
									unlink("../Amigos/".$archivosants[$i]);	
								}
							}
							if (copy("../TemporalAmigos/".$sexta."/".$archivos[2],"../Amigos/6.".$terminacion)) {
								rmdir_recurse("../TemporalAmigos/".$sexta);
							}
						}

}else{
	$objectivec = new stdClass;
	$directorio = scandir("../Amigos/");
	for ($i=2; $i < count($directorio); $i++) { 
		if (strpos($directorio[$i],'1') !== false) {
			$objectivec->primero = "Amigos/".$directorio[$i];
		}
		if (strpos($directorio[$i],'2') !== false) {
			$objectivec->segundo = "Amigos/".$directorio[$i];
		}
		if (strpos($directorio[$i],'3') !== false) {
			$objectivec->tercero = "Amigos/".$directorio[$i];
		}
		if (strpos($directorio[$i],'4') !== false) {
			$objectivec->cuarto = "Amigos/".$directorio[$i];
		}
		if (strpos($directorio[$i],'5') !== false) {
			$objectivec->quinto = "Amigos/".$directorio[$i];
		}
		if (strpos($directorio[$i],'6') !== false) {
			$objectivec->sexto = "Amigos/".$directorio[$i];
		}
	}
	echo json_encode($objectivec);
} ?>