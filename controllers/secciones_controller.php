<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	include '../dbc/dbconnect.php';
	include '../dbc/seccionesDAO.php';
	$dbconnect = new dbconnect('charm_charmlifec536978');
	$dbc = $dbconnect->getConnection();
	$seccionesDAO = new seccionesDAO($dbc);


	if (isset($_POST['action'])){
	$action = $_POST['action'];

	foreach ($_POST as $key => $value) {
		if($key != 'action'){
			$obj->$key = $value;
		}
	}

	if ($action == 'add'){
		$id = $seccionesDAO->insertSeccion($obj);
	}else if ($action == 'edit'){
		$seccionesDAO->updateSeccion($obj);
	}
		header("Location: /charmAdmin/administrator.php#secciones");
	}else if(isset($_POST['delete'])){
		$id = $_POST['delete'];
		$seccionesDAO->deleteSeccion($id);
		header("Location: /charmAdmin/administrator.php#secciones");
	}else{
		$secciones = $seccionesDAO->getSecciones();
		echo json_encode($secciones);	
	}
?>