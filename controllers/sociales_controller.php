<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

include '../dbc/dbconnect.php';
include '../dbc/socialesDAO.php';
include 'utilities.php';

$dbconnect = new dbconnect("charm_charmlifec536978");
$dbc = $dbconnect->getConnection();
$socialesdao = new socialesDAO($dbc);

if (isset($_POST['receiver']) && $_POST['receiver'] == "registro") {
	$social = new stdClass;
	foreach ($_POST as $key => $value) {
		if ($key != "receiver" || $key != "temporal") {
			$social->$key = $value;
		}
	}
	if (strlen($_POST['fecha']) == 0) {
		$social->fecha = date("Y")."-".date("m")."-".date("d");
	}else{
		$fechaexplotada = explode("/",$_POST['fecha']);
		$social->fecha = $fechaexplotada[2]."-".$fechaexplotada[0]."-".$fechaexplotada[1];
	}
	$idigen = $socialesdao->insertSocial($social);
	if (is_dir("../TemporalSociales/".$_POST['temporal'])) {
			$idgenerado = $idigen;
			$temporaldir = $_POST['temporal'];
			$fuente = "../TemporalSociales/".$temporaldir."/";
			$destino = "../Sociales/".$idgenerado."/";
			recurse_copy($fuente,$destino);
			if (is_dir("../TemporalSociales/".$temporaldir)) {
				rmdir_recurse("../TemporalSociales/".$temporaldir);
			}
		$imagenes = scandir("../Sociales/".$idigen);
		for ($i=2; $i < count($imagenes); $i++) { 
			if ($i != count($imagenes) -1) {
				$foto = new stdClass;
				$foto->url = "Sociales/".$idigen."/".$imagenes[$i];
				$foto->sociales_id = $idigen;
				$socialesdao->insertFoto($foto);
			}
		}
	}
	
	print_r($idigen);
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "socialcontinue") {
	$social = $socialesdao->getSocialById($_POST['idsocial']);
	$social->imagenes = $socialesdao->getImagenesbySocialId($social->sociales_id);
		
	$fechaexplotada = explode("-",$social->fecha);
	$social->dia = $fechaexplotada[2];
	$social->mes = $fechaexplotada[1];
	$social->year = $fechaexplotada[0];
	echo json_encode($social);
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "edicionfotos") {
	$id = $_POST['sociales_id'];
	$imagenes = array();
	foreach ($_POST as $key => $value) {
		if (is_numeric($key)) {
			$img = new stdClass;
			$img->id = $key;
			$img->descripcion = $value;
			$socialesdao->updateDescripcionFoto($img);
		}
	}
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "updatedatasocial") {
	$soci = new stdClass;
	foreach ($_POST as $key => $value) {
		$soci->$key = $value;
	}
		if (strlen($_POST['fecha']) == 0) {
			$soci->fecha = date("Y")."-".date("m")."-".date("d");
		}else{
			$fechaexplotada = explode("/",$_POST['fecha']);
			$soci->fecha = $fechaexplotada[2]."-".$fechaexplotada[0]."-".$fechaexplotada[1];
		}	
	$socialesdao->updateSocial($soci);
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "agregafotosocial") {
	$foto = $_POST['foto'];
	$social = $_POST['social_id'];
	$insercion = new stdClass;
	$insercion->url = "Sociales/".$social."/".$foto;
	$insercion->sociales_id = $social;
	$socialesdao->insertFoto($insercion);
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "borrarfoto") {
	$socia  = $_POST['social_id'];
	$foto = $_POST['foto'];
	$fotosacada = urldecode($foto);
	$aborr = new stdClass;
	$aborr->url = "Sociales/".$socia."/".$fotosacada;
	$aborr->sociales_id = $socia;
	$socialesdao->deleteFoto($aborr);
	print_r("Borre foto:");
	print_r($aborr);
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "borrar") {
	$id = $_POST['idsocial'];
	$soci = $socialesdao->getSocialById($id);
	$socialesdao->deleteSocial($soci);
	$socialesdao->deleteFotosBySocialId($soci->sociales_id);

	if (is_dir("../Sociales/".$id."/")) {
		rmdir_recurse("../Sociales/".$id."/");
	}
}
else{
	echo json_encode($socialesdao->getSociales());
} 
?>