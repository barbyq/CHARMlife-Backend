<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

include '../dbc/dbconnect.php';
include 'utilities.php';


if (isset($_POST['receiver']) && $_POST['receiver'] == "subirbanner") {
	$generado = $_POST['generado'];
		print_r($_FILES['banner']["type"]);
		if (is_dir('../TemporalBanner/'.$generado)) {
			rmdir_recurse('../TemporalBanner/'.$generado);
			mkdir('../TemporalBanner/'.$generado);
			if ($_FILES['banner']['type'] ==='image/jpeg') {
				move_uploaded_file($_FILES['banner']['tmp_name'],'../TemporalBanner/'.$generado.'/'.$generado.'.jpg');
			}else{
				move_uploaded_file($_FILES['banner']['tmp_name'],'../TemporalBanner/'.$generado.'/'.$generado.'.png');
			}		
		}else{
			mkdir('../TemporalBanner/'.$generado);
			if ($_FILES['banner']['type'] ==='image/jpeg') {
				move_uploaded_file($_FILES['banner']['tmp_name'],'../TemporalBanner/'.$generado.'/'.$generado.'.jpg');
			}else{
				move_uploaded_file($_FILES['banner']['tmp_name'],'../TemporalBanner/'.$generado.'/'.$generado.'.png');
			}
		}
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "confirmarbanner") {
	  	$temporaldir = $_POST['generado'];
		$fuente = "../TemporalBanner/".$temporaldir."/";
		$destino = "../Banner/";
		$archivos = scandir("../Banner/");
		$archivin = $archivos[2];
		unlink("../Banner/".$archivin);
		
		recurse_copy($fuente,$destino);
		if (is_dir("../TemporalBanner/".$temporaldir)) {
			rmdir_recurse("../TemporalBanner/".$temporaldir);
		}	
}else{
	$archivos = scandir("../Banner/");
	$banner = new stdClass;
	$banner->banner = "Banner/".$archivos[2];
	echo json_encode($banner);
} ?>