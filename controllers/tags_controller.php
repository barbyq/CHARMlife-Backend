<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

include '../dbc/dbconnect.php';
include '../dbc/tagsDAO.php';
include 'utilities.php';

$dbconnect = new dbconnect("charm_charmlifec536978");
$dbc = $dbconnect->getConnection();
 $tagsDao = new tagsDAO($dbc);

if (isset($_POST['registro'])) {
	$tag = new stdClass;
	foreach ($_POST as $key => $value) {
		$tag->$key = $value;
	}
	$tagsDao->registerTag($tag);
}elseif (isset($_POST['update'])) {
	foreach ($_POST as $key => $value) {
		$tag->$key = $value;
	}
	$tagsDao->updateTag($tag);
}elseif (isset($_POST['borrar'])) {
	$id = $_POST['borrar'];
	$tagsDao->deleteTag($id);
}elseif (isset($_POST['giveme'])) {
	$id = $_POST['giveme'];
	$tag = $tagsDao->givemetag($id);
	echo json_encode($tag);
}else{
	echo json_encode($tagsDao->dameTags());
} ?>