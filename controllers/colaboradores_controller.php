<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

include '../dbc/dbconnect.php';
include '../dbc/colaboradoresDAO.php';

$dbconnect = new dbconnect('charm_charmlifec536978');
$dbc = $dbconnect->getConnection();
$colabsDao = new colaboradoresDAO($dbc);
echo json_encode($colabsDao->getColaboradoresNombres());
?>