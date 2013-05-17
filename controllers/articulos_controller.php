<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

include '../dbc/dbconnect.php';
include '../dbc/articulosDAO.php';


 $dbconnect = new dbconnect('charm_charmlifec536978');
 $dbc = $dbconnect->getConnection();
 $articleDao = new articulosDAO($dbc);

if (isset($_POST['receiver'])) {
	$receiver = $_POST['receiver'];
}

if (isset($_POST['registro'])) {
	
}elseif (isset($receiver) && $receiver=="imagenprinci") {
	$generado = $_POST['generado'];
	print_r($_FILES['imagenprincipali']["type"]);
	if (is_dir('../TemporalImagenes/'.$generado)) {
		rmdir_recurse('../TemporalImagenes/'.$generado);
		mkdir('../TemporalImagenes/'.$generado);
		if ($_FILES['imagenprincipali']['type'] ==='image/jpeg') {
			move_uploaded_file($_FILES['imagenprincipali']['tmp_name'],'../../TemporalImagenes/'.$generado.'/'.$generado.'.jpg');
		}else{
			move_uploaded_file($_FILES['imagenprincipali']['tmp_name'],'../TemporalImagenes/'.$generado.'/'.$generado.'.png');
		}		
	}else{
		mkdir('../TemporalImagenes/'.$generado);
		if ($_FILES['imagenprincipali']['type'] ==='image/jpeg') {
			move_uploaded_file($_FILES['imagenprincipali']['tmp_name'],'../TemporalImagenes/'.$generado.'/'.$generado.'.jpg');
		}else{
			move_uploaded_file($_FILES['imagenprincipali']['tmp_name'],'../TemporalImagenes/'.$generado.'/'.$generado.'.png');
		}
	}
}elseif (isset($receiver) && $receiver == 'tomtom') {
	$generacion =  $_POST['generacion'];
	if (is_dir('../TemporalThumbnails/'.$generacion)) {
		rmdir_recurse('../TemporalThumbnails/'.$generacion);
		mkdir('../TemporalThumbnails/'.$generacion);
		if ($_FILES['tomneil']['type'] ==='image/jpeg') {
			move_uploaded_file($_FILES['tomneil']['tmp_name'],'../TemporalThumbnails/'.$generacion.'/'.$generacion.'.jpg');
		}else{
			move_uploaded_file($_FILES['tomneil']['tmp_name'],'../TemporalThumbnails/'.$generacion.'/'.$generacion.'.png');
		}
	}else{
		mkdir('../TemporalThumbnails/'.$generacion);
		if ($_FILES['tomneil']['type'] ==='image/jpeg') {
			move_uploaded_file($_FILES['tomneil']['tmp_name'],'../TemporalThumbnails/'.$generacion.'/'.$generacion.'.jpg');
		}else{
			move_uploaded_file($_FILES['tomneil']['tmp_name'],'../TemporalThumbnails/'.$generacion.'/'.$generacion.'.png');
		}
	}
}else{
	echo json_encode($articleDao->getArticulos());
}
?>