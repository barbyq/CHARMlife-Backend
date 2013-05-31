<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	include '../dbc/dbconnect.php';
	include 'utilities.php';
	include '../dbc/colaboradoresDAO.php';
	$dbconnect = new dbconnect('charm_charmlifec536978');
	$dbc = $dbconnect->getConnection();
	$colaboradoresDAO = new colaboradoresDAO($dbc);
	

	if (isset($_POST['receiver']) && $_POST['receiver'] == "subirprofile") {
		$generado = $_POST['generado'];
			print_r($_FILES['profilepic']["type"]);
			if (is_dir('../TemporalProfiles/'.$generado)) {
				rmdir_recurse('../TemporalProfiles/'.$generado);
				mkdir('../TemporalProfiles/'.$generado);
				if ($_FILES['profilepic']['type'] ==='image/jpeg') {
					move_uploaded_file($_FILES['profilepic']['tmp_name'],'../TemporalProfiles/'.$generado.'/'.$generado.'.jpg');
				}else{
					move_uploaded_file($_FILES['profilepic']['tmp_name'],'../TemporalProfiles/'.$generado.'/'.$generado.'.png');
				}		
			}else{
				mkdir('../TemporalProfiles/'.$generado);
				if ($_FILES['profilepic']['type'] ==='image/jpeg') {
					move_uploaded_file($_FILES['profilepic']['tmp_name'],'../TemporalProfiles/'.$generado.'/'.$generado.'.jpg');
				}else{
					move_uploaded_file($_FILES['profilepic']['tmp_name'],'../TemporalProfiles/'.$generado.'/'.$generado.'.png');
				}
			}
	}

		if (isset($_POST['receiver']) && $_POST['receiver'] == "editupload") {
			$generado = $_POST['generado'];
				print_r($_FILES['imagen']["type"]);
				if (is_dir('../Profiles/'.$generado)) {
					rmdir_recurse('../Profiles/'.$generado);
					mkdir('../Profiles/'.$generado);
					if ($_FILES['imagen']['type'] ==='image/jpeg') {
						move_uploaded_file($_FILES['imagen']['tmp_name'],'../Profiles/'.$generado.'/'.$generado.'.jpg');
					}else{
						move_uploaded_file($_FILES['imagen']['tmp_name'],'../Profiles/'.$generado.'/'.$generado.'.png');
					}		
				}else{
					mkdir('../Profiles/'.$generado);
					if ($_FILES['imagen']['type'] ==='image/jpeg') {
						move_uploaded_file($_FILES['imagen']['tmp_name'],'../Profiles/'.$generado.'/'.$generado.'.jpg');
					}else{
						move_uploaded_file($_FILES['imagen']['tmp_name'],'../Profiles/'.$generado.'/'.$generado.'.png');
					}
				}
		}

	if (isset($_POST['action'])){
		$obj = new stdClass;
		$action = $_POST['action'];
		
		foreach ($_POST as $key => $value) {
			if($key != 'action'){
				$obj->$key = $value;
			}
		}

if (isset($_POST['receiver']) && $_POST['receiver'] == "registro") {
	$user = new stdClass;
	foreach ($_POST as $key => $value) {
		$user->$key = $value;
	}
	$id = $colaboradoresDAO->insertColaborador($user);
	if (is_dir("../TemporalProfiles/".$_POST['temporal'])) {
		mkdir("../Profiles/".$id."/");
		$temporaldir = $_POST['temporal'];
		$fuente = "../TemporalProfiles/".$temporaldir."/";
		$destino = "../Profiles/".$id."";
		recurse_copy($fuente,$destino);
		$escan = scandir("../Profiles/".$id."/");
		$user->imagen = "Profiles/".$id."/".$escan[2];
		$user->id = $id;
		$colaboradoresDAO->updateColaborador($user);
		if (is_dir("../TemporalProfiles/".$temporaldir)) {
			rmdir_recurse("../TemporalProfiles/".$temporaldir);
		}
	}
	foreach ($user->secciones as $seccion) {
		$colaboradoresDAO->insertColaboradorSecciones($seccion,$id);
	}
}

		if (isset($_POST['receiver']) && $_POST['receiver'] == "editar"){
			$user = new stdClass;
			foreach ($_POST as $key => $value) {
				$user->$key = $value;
			}

			if (is_dir("../Profiles/".$_POST['id']."/")) {
				$escaneo = scandir("../Profiles/".$_POST['id']."/");
				$user->imagen = "Profiles/".$_POST['id']."/".$escaneo[2];
			}
			$colaboradoresDAO->updateColaborador($user);
			$colaboradoresDAO->deleteColaboradorSecciones($user->id);

			foreach ($user->secciones as $seccion) {
				$colaboradoresDAO->insertColaboradorSecciones($seccion,$user->id);			
			}
		}
		
	}else if(isset($_POST['receiver']) && $_POST['receiver'] == "borrar"){
		$id = $_POST['idcolab'];
		$colaboradoresDAO->deleteColaboradorSecciones($id);
		$colaboradoresDAO->deleteColaborador($id);

		$dir = '../Profiles/'.$id.'/';
		if (is_dir($dir)){	
			rmdir_recurse($dir);
		}

	}else{
		$colaboradores = $colaboradoresDAO->getColaboradores();	
		foreach ($colaboradores as $colaborador) {
			$colaborador->secciones = $colaboradoresDAO->getSeccionesColaborador($colaborador->id);
		}
		echo json_encode($colaboradores);
	}
?>

