<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

include '../dbc/dbconnect.php';
include '../dbc/seccionesDAO.php';

$dbconnect = new dbconnect('charm_charmlifec536978');
$dbc = $dbconnect->getConnection();
$seccionesDao = new seccionesDAO($dbc);
echo json_encode($seccionesDao->getSecciones());
?>