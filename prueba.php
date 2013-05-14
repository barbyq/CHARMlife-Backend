<?php
include_once 'dbc/dbconnect.php';
include_once 'dbc/portadasDAO.php';
$dbconnect = new dbconnect('charm_charmlifec536978');
$dbc = $dbconnect->getConnection();
$portadasDAO = new portadasDAO($dbc);
echo $portadasDAO->getEdicion(4, 2012);




?>