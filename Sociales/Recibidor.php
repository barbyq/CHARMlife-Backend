<?php 
session_start();
print_r($_REQUEST);
if (isset($_POST['temporaral'])) {
	$_SESSION['id'] = $_POST['temporaral']; 
}
 ?>