<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

include '../dbc/dbconnect.php';
include '../dbc/usuariosDAO.php';
include 'utilities.php';

$dbconnect = new dbconnect("charm_charmlifec536978");
$dbc = $dbconnect->getConnection();
$userDAO = new usuariosDAO($dbc);

if (isset($_POST['registro'])) {
	$user = new stdClass;
	$user->nombre = $_POST['nombre'];
	$user->username = $_POST['username'];
	$user->password = $_POST['password'];
	$user->levelup = $_POST['permisos'];
	$userDAO->registerUser($user);
}elseif (isset($_POST['update'])) {
	$user = new stdClass;
	$user->id = $_POST['usuario_id'];
	$user->nombre = $_POST['nombre'];
	$user->username = $_POST['username'];
	$user->password = $_POST['password'];
	$user->levelup = $_POST['permisos'];
	$userDAO->updateUser($user);	
}elseif (isset($_POST['borrar'])) {
	$id = $_POST['borrar'];
	$userDAO->eraseUser($id);
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "letmein") {
	$username = $_POST['usi'];
	$password = $_POST['yadayada'];
	$queonda = $userDAO->getUser($username);

	if (isset($queonda->username)) {
		if ($queonda->password == $password) {
			session_start();
			$_SESSION['user'] = $queonda;
			header("Location: ../administrator.php");
		}else{
			header("Location: ../index.php");
		}
	}else {
		header("Location: ../index.php");
	}
}
else{
	echo json_encode($userDAO->getUsuarios());
} ?>