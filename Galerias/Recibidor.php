<?php 
session_start();
print_r($_REQUEST);
print_r($_SESSION);
if (isset($_POST['temporaral'])) {
	$_SESSION['idedicion'] = $_POST['temporaral']; 
}
 ?>