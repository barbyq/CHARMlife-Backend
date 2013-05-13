<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

include '../dbc/dbconnect.php';
include '../dbc/articulosDAO.php';
include '../utilities.php';

$dbconnect = new dbconnect('charm_charmlifec536978');
$dbc = $dbconnect->getConnection();
$articleDao = new articulosDAO($dbc);


 ?>