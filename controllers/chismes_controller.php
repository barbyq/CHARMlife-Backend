<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include '../dbc/dbconnect.php';
include '../dbc/chismesDAO.php';
include 'utilities.php';

$dbconnect = new dbconnect('charm_charmlifec536978');
$dbc = $dbconnect->getConnection();
$chismidao = new chismesDAO($dbc);

if (isset($_POST['receiver']) && $_POST['receiver'] == "registro") {
	print_r($_REQUEST);
	$chisme = new stdClass;
	$chisme->titulo = $_POST['titulo'];
	$chisme->texto = $_POST['texto'];
	$chisme->link = $_POST['link'];

	if (strlen($_POST['fecha']) == 0) {
		$chisme->fecha = date("Y")."-".date("m")."-".date("d");
	}else{
		$fechaexplotada = explode("/",$_POST['fecha']);
		$chisme->fecha = $fechaexplotada[2]."-".$fechaexplotada[0]."-".$fechaexplotada[1];
	}
	$chisme->foto = "0";
	
	$idgenerado = $chismidao->insertChisme($chisme);
	$temporaldir = $_POST['temporal'];
	
	if (is_dir('../TemporalChismes/'.$temporaldir)) {
		mkdir('../Chismes/'.$idgenerado);
		recurse_copy('../TemporalChismes/'.$temporaldir,'../Chismes/'.$idgenerado);
		rmdir_recurse('../TemporalChismes/'.$temporaldir);
		$escaneo = scandir('../Chismes/'.$idgenerado);
		$tipo = substr($escaneo[2],strlen($escaneo[2]) - 3);
		print_r($tipo);
		rename('../Chismes/'.$idgenerado.'/'.$escaneo[2],'../Chismes/'.$idgenerado.'/'.$idgenerado.'.'.$tipo);
		$chisme->foto = 'Chismes/'.$idgenerado.'/'.$idgenerado.'.'.$tipo;
		$chisme->id = $idgenerado;
		print_r($chisme);
		$chismidao->updateChisme($chisme);
	}	

}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "imagenchisme") {
	$generado = $_POST['generado'];
	print_r($_FILES['imagenchisme']["type"]);
	if (is_dir('../TemporalChismes/'.$generado)) {
		rmdir_recurse('../TemporalChismes/'.$generado);
		mkdir('../TemporalChismes/'.$generado);
		if ($_FILES['imagenchisme']['type'] =='image/jpeg') {
			print_r("Es jpg");
			move_uploaded_file($_FILES['imagenchisme']['tmp_name'],'../TemporalChismes/'.$generado.'/'.$generado.'.jpg');
		}else{
			move_uploaded_file($_FILES['imagenchisme']['tmp_name'],'../TemporalChismes/'.$generado.'/'.$generado.'.png');
		}		
	}else{
		mkdir('../TemporalChismes/'.$generado);
		if ($_FILES['imagenchisme']['type'] =='image/jpeg') {
			print_r("Es jpg");
			move_uploaded_file($_FILES['imagenchisme']['tmp_name'],'../TemporalChismes/'.$generado.'/'.$generado.'.jpg');
		}else{
			move_uploaded_file($_FILES['imagenchisme']['tmp_name'],'../TemporalChismes/'.$generado.'/'.$generado.'.png');
		}
	}
}elseif(isset($_POST['receiver']) && $_POST['receiver'] == "damechisme"){
	$id = $_POST['chismeid'];
	$chisme = $chismidao->getChismeById($id);

	$fechaexplotada = explode("-",$chisme->fecha);
	$chisme->year = $fechaexplotada[0];
	$chisme->mes = $fechaexplotada[1];
	$chisme->dia = $fechaexplotada[2];
	echo json_encode($chisme);
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "update") {
	print_r($_REQUEST);
	$chisme = new stdClass;
	$chisme->titulo = $_POST['titulo'];
	$chisme->texto = $_POST['texto'];
	$chisme->link = $_POST['link'];
	$chisme->id = $_POST['chismeid'];
	if (strlen($_POST['fecha']) == 0) {
		$chisme->fecha = date("Y")."-".date("m")."-".date("d");
	}else{
		$fechaexplotada = explode("/",$_POST['fecha']);
		$chisme->fecha = $fechaexplotada[2]."-".$fechaexplotada[0]."-".$fechaexplotada[1];
	}
	$chisme->foto = "Chismes/".$chisme->id."/".$chisme->id.".jpg";
	$chismidao->updateChisme($chisme);
}elseif (isset($_POST['receiver']) &&  $_POST['receiver'] == "updateimagen") {
	$idamodificar = $_POST['idchisme'];
	if (is_dir("../Chismes/".$idamodificar)) {
		rmdir_recurse("../Chismes/".$idamodificar);
		mkdir("../Chismes/".$idamodificar);
		if ($_FILES['imagenchisme']['type'] == 'image/jpeg') {
			move_uploaded_file($_FILES['imagenchisme']['tmp_name'],"../Chismes/".$idamodificar."/".$idamodificar.".jpg");
		}elseif ($_FILES['imagenchisme']['type'] == 'image/png') {
			move_uploaded_file($_FILES['imagenchisme']['tmp_name'],"../Chismes/".$idamodificar."/".$idamodificar.".png");
		}
	}else{
		mkdir("../Chismes/".$idamodificar);
		if ($_FILES['imagenchisme']['type'] == 'image/jpeg') {
			move_uploaded_file($_FILES['imagenchisme']['tmp_name'],"../Chismes/".$idamodificar."/".$idamodificar.".jpg");
		}elseif ($_FILES['imagenchisme']['type'] == 'image/png') {
			move_uploaded_file($_FILES['imagenchisme']['tmp_name'],"../Chismes/".$idamodificar."/".$idamodificar.".png");
		}
	}
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "borrar") {
	$id = $_POST['idchisme'];
	$chismidao->deleteChisme($id);
	if (is_dir("../Chismes/".$id)) {
		rmdir_recurse("../Chismes/".$id);
	}
}else{
	echo json_encode($chismidao->getChismes());
}
?>