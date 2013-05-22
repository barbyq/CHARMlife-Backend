<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	include '../dbc/dbconnect.php';
	include '../utilities.php';
	include '../dbc/colaboradoresDAO.php';
	$dbconnect = new dbconnect('charm_charmlifec536978');
	$dbc = $dbconnect->getConnection();
	$colaboradoresDAO = new colaboradoresDAO($dbc);
	

	if (isset($_POST['action'])){
		$obj = new stdClass;
		$action = $_POST['action'];
		
		foreach ($_POST as $key => $value) {
			if($key != 'action'){
				$obj->$key = $value;
			}
		}

		if ($action == 'add'){
			$imagen = $obj->imagen;

			$haystack = $obj->imagen;
			$needle   = '/';
			
			$temp = substr($obj->imagen, '0', strripos($haystack, $needle));
			
			
			$obj->imagen = substr($obj->imagen, strripos($haystack, $needle)+1, strlen($obj->imagen));
			


			$id = $colaboradoresDAO->insertColaborador($obj);
			foreach ($obj->secciones as $seccion) {
				$colaboradoresDAO->insertColaboradorSecciones($seccion, $id);
			}
			if ($id){
				$dir = '../upload/colaboradores/'.$id.'/';
				if (!is_dir($dir)){	
					mkdir($dir);
				}
				if (copy("../upload/colaboradores/temp/".$imagen ,$dir . $obj->imagen)) {
				  if (is_dir("../upload/colaboradores/temp/".$temp)){	
						rrmdir("../upload/colaboradores/temp/".$temp);
					}
				}
			}
			header("Location: /proyectoDigital/administrator.php#colaboradores");
		}
		if ($action == 'edit'){
			if (!empty($obj->imgs)){
				$imgs = explode("," , $obj->imgs);
				unlink('../upload/colaboradores/' . $obj->id  . '/'. $obj->imagen);		
				for ($i = 0; $i < count($imgs); $i++){
					if ($i != (count($imgs)-1)){
						unlink('../' . $imgs[$i]);
					}else{
						$obj->imagen = substr($imgs[$i], strripos($imgs[$i], '/')+1);
					}		

				}
			}			
			$colaboradoresDAO->updateColaborador($obj);
			$colaboradoresDAO->deleteColaboradorSecciones($obj->id);
			foreach ($obj->secciones as $seccion){
				$colaboradoresDAO->insertColaboradorSecciones($seccion, $obj->id);				
			}
			header("Location: /proyectoDigital/administrator.php#colaboradores/" . $obj->id);
		}
		
	}else if(isset($_POST['delete'])){
		$id = $_POST['delete'];
		$colaboradoresDAO->deleteColaboradorSecciones($id);
		$colaboradoresDAO->deleteColaborador($id);

		$dir = '../upload/colaboradores/'.$id.'/';
		if (is_dir($dir)){	
			rrmdir($dir);
		}


	}else{
		$colaboradores = $colaboradoresDAO->getColaboradores();	
		echo json_encode($colaboradores);
	}
?>

