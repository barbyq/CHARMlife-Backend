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
	
	echo json_encode($social);
}else{
	echo json_encode($socialesdao->getSociales());
} 
?>