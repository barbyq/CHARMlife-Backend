<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	include '../dbc/dbconnect.php';
	include '../dbc/utilities.php';
	include '../dbc/portadasDAO.php';

	$dbconnect = new dbconnect('charm_charmlifec536978');
	$dbc = $dbconnect->getConnection();
	$portadasDAO = new portadasDAO($dbc);

	if (isset($_POST['action'])){
		$action = $_POST['action'];
	
		foreach ($_POST as $key => $value) {
			if($key != 'action'){
				$obj->$key = $value;
			}
		}

		if (!empty($obj->imgs)){
			$imgs = explode("," , $obj->imgs);
			$originalImg = substr($imgs[0], strripos($imgs[0], '/'), strlen($imgs[0]));
			$i1 = count($imgs)-1;
			$obj->img = substr($imgs[$i1], strripos($imgs[$i1], '/')+1, strlen($imgs[$i1]));
		}

		if (!empty($obj->imgs_mob)){
			$imgs_mob = explode("," , $obj->imgs_mob);
			$originalImgMob = substr($imgs_mob[0], strripos($imgs_mob[0], '/'), strlen($imgs_mob[0]));
			$i2 = count($imgs_mob)-1;
			$obj->img_thumb = substr($imgs_mob[$i2], strripos($imgs_mob[$i2], '/')+1, strlen($imgs_mob[$i2]));
		}
		if ($action == 'add'){
		
		$id = $portadasDAO->insertPortada($obj);
		
		
	}else if ($action == 'edit'){
		$portadasDAO->updatePortada($obj);
		$id = $obj->id;
	}

	$dir = '../upload/portadas/' . $id . '/';
	if (!is_dir($dir)){	
		mkdir($dir);
	}
	
	if (!empty($obj->imgs)){
		$temp = substr($imgs[$i1], 0, strripos($imgs[$i1], '/'));
		/*echo '<br/><br/>temp:';
		print_r($temp);
		echo '<br/><br/>banner:';
		print_r($obj->banner_grande);
		echo '<br/><br/>';
		print_r($imgs[$i1]);
		echo '<br/><br/>banner_grande: ';
		echo($dir . $obj->banner_grande);*/

		if(empty($obj->imgs_mob)){
			/*Borrar Imagenes de temp y mover la buena a la carpeta*/
			if (copy("../upload/portadas/".$imgs[$i1], $dir . $obj->img)){
				if (is_dir("../upload/portadas/".$temp)){	
					rrmdir("../upload/portadas/".$temp);
				}	
			}
			//borrar la imagen original cuando editas
			if ($action == 'edit'){
				if ($originalImg != $obj->img){
					unlink($dir. $originalImg);		
				}
				
			}
		}
		
		
	}

	if (!empty($obj->imgs_mob)){
		$temp = substr($imgs_mob[$i2], 0, strripos($imgs_mob[$i2], '/'));
		
		if (!empty($obj->imgs)){
		/*Borrar Imagenes de temp y mover la buena a la carpeta*/
			if (copy("../upload/portadas/".$imgs[$i1], $dir . $obj->img)){}
			//borrar la imagen original cuando editas
			if ($action == 'edit'){
				if ($originalImg != $obj->img){
					unlink($dir. $originalImg);
				}
			}
		}


		/*Borrar Imagenes de temp y mover la buena a la carpeta*/
		if (copy("../upload/portadas/".$imgs_mob[$i2], $dir . $obj->img_thumb)){
			if (is_dir("../upload/portadas/".$temp)){	
				rrmdir("../upload/portadas/".$temp);
			}	
		}
		//borrar la imagen original cuando editas
		if ($action == 'edit'){
			if ($originalImgMob != $obj->img_thumb){
				unlink($dir. $originalImgMob);
			}
		}
	}	
	
	header("Location: /charmAdmin/administrator.php#portadas/". $id);

	}else if(isset($_POST['delete'])){
		$id = $_POST['delete'];
		$portadasDAO->deletePortada($id);

		$dir = '../upload/portadas/'.$id.'/';
		if (is_dir($dir)){	
			rrmdir($dir);
		}
	}elseif (isset($_POST['years'])) {
		$plaza = $_POST['plazabusqueda'];
		echo json_encode($portadasDAO->showyears($plaza));
	}elseif (isset($_POST['year'])) {
		$an = $_POST['year'];
		$plas = $_POST['plazota'];
		echo json_encode($portadasDAO->dameporYearyPlaza($an,$plas));
	}elseif (isset($_GET["comida"])) {
			$portadas = $portadasDAO->execute();
	}
	else{
		$portadas = $portadasDAO->getPortadas();
		echo json_encode($portadas);
	}
?>