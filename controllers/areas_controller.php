<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include '../dbc/dbconnect.php';
include '../dbc/areasDAO.php';

$dbconnect = new dbconnect('charm_charmlifec536978');
$dbc = $dbconnect->getConnection();
$areasDAO = new areasDAO($dbc);

if (isset($_POST['action'])){
	$action = $_POST['action'];
	
	foreach ($_POST as $key => $value) {
		if($key != 'action'){
			$obj->$key = $value;
		}
	}


	if ($action == 'add'){
		$id = $areasDAO->insertArea($obj);
	}else if ($action == 'edit'){
		$areasDAO->updateArea($obj);
	}
	header("Location: /charmAdmin/administrator.php#areas");
}else if(isset($_POST['delete'])){
	$id = $_POST['delete'];
	$areasDAO->deleteArea($id);
	header("Location: /charmAdmin/administrator.php#areas");
}else{
	$areas = $areasDAO->getAreas();
	echo json_encode($areas);	
}
?>