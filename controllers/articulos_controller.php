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
	$titulo = $_POST['titulo'];
	$plaza = $_POST['plaza'];
	$status = $_POST['status'];
	$medio = $_POST['medio'];
	$subtitulo = $_POST['subtitulo'];
	$tags = $_POST['tags'];
	$tipo = $_POST['tipo'];
	$video = $_POST['videourl'];
	$fecha = $_POST['fechaevento'];
	$colaborador = $_POST['colaboradores'];
	$seccion = $_POST['secciones'];
	$contenido = $_POST['contenido'];

	$articulo = new stdClass;
	$articulo->titulo = $titulo;
	$articulo->status = $status;
	$articulo->tipo = $tipo;
	$articulo->colaborador_id = $colaborador;
	$articulo->contenido = $contenido;
	$articulo->plaza = $plaza;
	$articulo->medio = $medio;
	$articulo->user = $user;
	$articulo->fechagaleria = $fechaparagaleria;
	// $articulo->dia = date('d');
	// $articulo->mes = date('m');
	// $articulo->year = date('Y');
	$articulo->seccion = $seccion;
	$articulo->subtitulo = $subtitle;

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