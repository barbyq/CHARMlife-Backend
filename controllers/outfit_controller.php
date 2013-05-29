<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

include 'utilities.php'; 

if (isset($_POST['receiver']) && $_POST['receiver'] == "subiroutfit") {
	$generado = $_POST['generado'];
			print_r($_FILES['temporaloutfit']["type"]);
			if (is_dir('../TemporalOutfit/'.$generado)) {
				rmdir_recurse('../TemporalOutfit/'.$generado);
				mkdir('../TemporalOutfit/'.$generado);
				if ($_FILES['temporaloutfit']['type'] ==='image/jpeg') {
					move_uploaded_file($_FILES['temporaloutfit']['tmp_name'],'../TemporalOutfit/'.$generado.'/'.$generado.'.jpg');
				}else{
					move_uploaded_file($_FILES['temporaloutfit']['tmp_name'],'../TemporalOutfit/'.$generado.'/'.$generado.'.png');
				}		
			}else{
				mkdir('../TemporalOutfit/'.$generado);
				if ($_FILES['temporaloutfit']['type'] ==='image/jpeg') {
					move_uploaded_file($_FILES['temporaloutfit']['tmp_name'],'../TemporalOutfit/'.$generado.'/'.$generado.'.jpg');
				}else{
					move_uploaded_file($_FILES['temporaloutfit']['tmp_name'],'../TemporalOutfit/'.$generado.'/'.$generado.'.png');
				}
			}	
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "confirmaroutfit") {
	  		$temporaldir = $_POST['generado'];
			$fuente = "../TemporalOutfit/".$temporaldir."/";
			$destino = "../Outfit/";

			$archivos = scandir("../Outfit/");
			$archivin = $archivos[2];
			unlink("../Outfit/".$archivin);
			
			recurse_copy($fuente,$destino);
			if (is_dir("../TemporalOutfit/".$temporaldir)) {
				rmdir_recurse("../TemporalOutfit/".$temporaldir);
			}
}else {
	$archivos = scandir("../Outfit/");
	$outfit = new stdClass;
	$outfit->outfit = "Outfit/".$archivos[2];
	echo json_encode($outfit);
} ?>