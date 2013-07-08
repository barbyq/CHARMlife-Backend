<?php 

include '../dbc/dbconnect.php';
include '../dbc/articulosDAO.php';
include 'utilities.php';

 $dbconnect = new dbconnect('charm_charmlifec536978');
 $dbc = $dbconnect->getConnection();
 $articleDao = new articulosDAO($dbc);

if (isset($_POST['receiver'])) {
	$receiver = $_POST['receiver'];
}

if (isset($_POST['registro'])) {
	$titulo = $_POST['titulo'];
	$status = $_POST['status'];
	$medio = $_POST['medio'];
	$subtitulo = $_POST['subtitulo'];
	$tags = $_POST['tags'];
	$tipo = $_POST['tipo'];
	$video = $_POST['videourl'];
	$user = $_POST['userId'];
	$fecha = $_POST['fechaevento'];
	$colaborador = $_POST['colaboradores'];
	$seccion = $_POST['secciones'];
	$contenido = $_POST['contenido'];
	$temporaldir = $_POST['temporal'];

	$articulo = new stdClass;
	$articulo->titulo = $titulo;
	$articulo->status = $status;
	$articulo->tipo = $tipo;
	$articulo->colaborador_id = $colaborador;
	$articulo->contenido = $contenido;
	$articulo->medio = $medio;
	$articulo->user = $user;
	if (strlen($fecha) == 0) {
		$articulo->mes = date('m');
		$articulo->dia = date('d');
		$articulo->year = date('Y');			
	}else{
		$fechaexplotada = explode("/",$fecha);
		$articulo->mes = $fechaexplotada[0];
		$articulo->dia = $fechaexplotada[1];
		$articulo->year = $fechaexplotada[2];
	}
	$articulo->seccion = $seccion;
	$articulo->subtitulo = $subtitulo;

	print_r($articulo);
	$idgenerado = $articleDao->insertArticulo($articulo);
	$articleDao->insertArticuloTags($tags,$idgenerado);

	if ($tipo=="1") {
		$fuente = "../TemporalGalerias/".$temporaldir."/files/";
		$destino = "../Galerias/".$idgenerado."/";
		recurse_copy($fuente,$destino);
		if (is_dir("../TemporalGalerias/".$temporaldir)) {
			rmdir_recurse("../TemporalGalerias/".$temporaldir);
		}
	}elseif ($tipo=="2") {
		echo "que onda";
		 $articleDao->registervideourl($video,$idgenerado);
	}

	$dbconnect->closeConnection();

	if (is_dir('../TemporalImagenes/'.$temporaldir)) {
		mkdir('../Imagenes/'.$idgenerado);
		recurse_copy('../TemporalImagenes/'.$temporaldir,'../Imagenes/'.$idgenerado);
		rmdir_recurse('../TemporalImagenes/'.$temporaldir);
		$escaneo = scandir('../Imagenes/'.$idgenerado);
		$tipo = substr($escaneo[2],strlen($escaneo[2]) - 3);
		print_r($tipo);
		rename('../Imagenes/'.$idgenerado.'/'.$escaneo[2],'../Imagenes/'.$idgenerado.'/'.$idgenerado.'.'.$tipo);
	}

	if (is_dir('../TemporalThumbnails/'.$temporaldir)) {
		mkdir('../Thumbnails/'.$idgenerado);
		recurse_copy('../TemporalThumbnails/'.$temporaldir,'../Thumbnails/'.$idgenerado);
		rmdir_recurse('../TemporalThumbnails/'.$temporaldir);
		$escaneo = scandir('../Thumbnails/'.$idgenerado);
		$tipo = substr($escaneo[2],strlen($escaneo[2]) - 3);
		print_r($tipo);
		rename('../Thumbnails/'.$idgenerado.'/'.$escaneo[2],'../Thumbnails/'.$idgenerado.'/'.$idgenerado.'.'.$tipo);
	}

	if (is_dir("../TemporalMasCharm/".$temporaldir."/")) {
		$fuente = "../TemporalMasCharm/".$temporaldir."/";
		$destino = "../MasCharm/".$idgenerado."/";
		recurse_copy($fuente,$destino);
		if (is_dir("../TemporalMasCharm/".$temporaldir)) {
			rmdir_recurse("../TemporalMasCharm/".$temporaldir);
		}
	}

}elseif (isset($receiver) && $receiver == "borrar") {
	$id = $_POST['idarticulo'];
	$articulo = $articleDao->getArticulo($id);

	if ($articulo->tipo == "1") {
		if (is_dir("../Galerias/".$id)) {
			rmdir_recurse('../Galerias/'.$id);	
		}
	}elseif ($articulo->tipo == "2") {
		$articleDao->deleteArticuloMedia($articulo->articulo_id);
	}

	if (is_dir("../Imagenes/".$id)) {
		rmdir_recurse('../Imagenes/'.$id);
	}
	if (is_dir("../Thumbnails/".$id)) {
		rmdir_recurse("../Thumbnails/".$id);
	}
	if (is_dir("../MasCharm/".$id)) {
		rmdir_recurse("../MasCharm/".$id);
	}
	$articleDao->deleteArticulo($id);
	$articleDao->deleteArticuloTags($id);
}elseif (isset($receiver) && $receiver == "dameimagenes") {
	$articulo = $_POST['articuloid'];
	$jsonlocation = new stdClass;

	if (is_dir('../Imagenes/'.$articulo)) {
		$imagenprincipal = scandir('../Imagenes/'.$articulo);
		$jsonlocation->imagenprincipal = $imagenprincipal[2];
	}
	if (is_dir('../Thumbnails/'.$articulo)) {
		$tomneil = scandir('../Thumbnails/'.$articulo);
		$jsonlocation->thumbnail = $tomneil[2];
	}
	echo json_encode($jsonlocation);
}elseif (isset($receiver) && $receiver == "damevideo") {
	$video = $_POST['idvide'];
	echo $articleDao->dameurlvid($video);
}elseif (isset($receiver) && $receiver == "contenido") {
	$id = $_POST['articulo'];
	$tags = $articleDao->getArticuloTags($id);

	$imagenes = new stdClass;

	if (is_dir('../Imagenes/'.$id)) {
		$imagenprincipal = scandir('../Imagenes/'.$id);
		if (isset($imagenprincipal[2])) {
			$imagenes->imagen = $imagenprincipal[2];
		}else{
			$imagenes->imagen = "img/ImagenPrinciDefault.png";
		}
	}
	if (is_dir('../Thumbnails/'.$id)) {
		$tomneil = scandir('../Thumbnails/'.$id);
		if (isset($tomneil[2])) {
		 	$imagenes->thumbnail = $tomneil[2];
		}else{
			$imagenes->thumbnail = "img/Tomneil.png";
		}
	}

	if (is_dir('../MasCharm/'.$id)) {
		$mascharm = scandir('../MasCharm/'.$id);
		if (isset($mascharm[2])) {
			$imagenes->mascharm = $mascharm[2];
		}else{
			$imagenes->mascharm = "img/Tomneil.png";
		}
	}
	
	$video = $articleDao->dameurlvid($id);

	$jsoncontenido = new stdClass;
	$jsoncontenido->tags = $tags;
	$jsoncontenido->imagenes = $imagenes;
	$jsoncontenido->videourl = $video;
	echo json_encode($jsoncontenido);
}elseif (isset($receiver) && $receiver=="imagenprinci") {
	$generado = $_POST['generado'];
	print_r($_FILES['imagenprincipali']["type"]);
	if (is_dir('../TemporalImagenes/'.$generado)) {
		rmdir_recurse('../TemporalImagenes/'.$generado);
		mkdir('../TemporalImagenes/'.$generado);
		if ($_FILES['imagenprincipali']['type'] ==='image/jpeg') {
			move_uploaded_file($_FILES['imagenprincipali']['tmp_name'],'../TemporalImagenes/'.$generado.'/'.$generado.'.jpg');
		}else{
			move_uploaded_file($_FILES['imagenprincipali']['tmp_name'],'../TemporalImagenes/'.$generado.'/'.$generado.'.png');
		}		
	}else{
		mkdir('../TemporalImagenes/'.$generado);
		if ($_FILES['imagenprincipali']['type'] ==='image/jpeg') {
			move_uploaded_file($_FILES['imagenprincipali']['tmp_name'],'../TemporalImagenes/'.$generado.'/'.$generado.'.jpg');
		}else{
			move_uploaded_file($_FILES['imagenprincipali']['tmp_name'],'../TemporalImagenes/'.$generado.'/'.$generado.'.png');
		}
	}
}elseif (isset($receiver) && $receiver == 'tomtom') {
	$generacion =  $_POST['generacion'];
	if (is_dir('../TemporalThumbnails/'.$generacion)) {
		rmdir_recurse('../TemporalThumbnails/'.$generacion);
		mkdir('../TemporalThumbnails/'.$generacion);
		if ($_FILES['tomneil']['type'] ==='image/jpeg') {
			move_uploaded_file($_FILES['tomneil']['tmp_name'],'../TemporalThumbnails/'.$generacion.'/'.$generacion.'.jpg');
		}else{
			move_uploaded_file($_FILES['tomneil']['tmp_name'],'../TemporalThumbnails/'.$generacion.'/'.$generacion.'.png');
		}
	}else{
		mkdir('../TemporalThumbnails/'.$generacion);
		if ($_FILES['tomneil']['type'] ==='image/jpeg') {
			move_uploaded_file($_FILES['tomneil']['tmp_name'],'../TemporalThumbnails/'.$generacion.'/'.$generacion.'.jpg');
		}else{
			move_uploaded_file($_FILES['tomneil']['tmp_name'],'../TemporalThumbnails/'.$generacion.'/'.$generacion.'.png');
		}
	}
}elseif (isset($receiver) && $receiver == "damearticulo") {
	$idadar = $_POST['idarticulo'];
	echo json_encode($articleDao->getArticulo($idadar));
}elseif (isset($receiver) && $receiver == "updateprincipal") {
	$idamodificar = $_POST['id'];
	if (is_dir("../Imagenes/".$idamodificar)) {
		rmdir_recurse("../Imagenes/".$idamodificar);
		mkdir("../Imagenes/".$idamodificar);
		if ($_FILES['principal']['type'] == 'image/jpeg') {
			move_uploaded_file($_FILES['principal']['tmp_name'],"../Imagenes/".$idamodificar."/".$idamodificar.".jpg");
		}elseif ($_FILES['principal']['type'] == 'image/png') {
			move_uploaded_file($_FILES['principal']['tmp_name'],"../Imagenes/".$idamodificar."/".$idamodificar.".png");
		}
	}else{
		mkdir("../Imagenes/".$idamodificar);
		if ($_FILES['principal']['type'] == 'image/jpeg') {
			move_uploaded_file($_FILES['principal']['tmp_name'],"../Imagenes/".$idamodificar."/".$idamodificar.".jpg");
		}elseif ($_FILES['principal']['type'] == 'image/png') {
			move_uploaded_file($_FILES['principal']['tmp_name'],"../Imagenes/".$idamodificar."/".$idamodificar.".png");
		}
	}
}elseif (isset($receiver) && $receiver == "updatethumbnail") {
	$cosha = $_POST['id'];
	if (is_dir("../Thumbnails/".$cosha)) {
		rmdir_recurse("../Thumbnails/".$cosha);
		mkdir("../Thumbnails/".$cosha);
		if ($_FILES['thumbnail']['type'] == 'image/jpeg') {
			move_uploaded_file($_FILES['thumbnail']['tmp_name'],"../Thumbnails/".$cosha."/".$cosha.".jpg");
		}elseif ($_FILES['thumbnail']['type'] == 'image/png') {
			move_uploaded_file($_FILES['thumbnail']['tmp_name'],"../Thumbnails/".$cosha."/".$cosha.".png");
		}
	}else{
		mkdir("../Thumbnails/".$cosha);
		if ($_FILES['thumbnail']['type'] == 'image/jpeg') {
			move_uploaded_file($_FILES['thumbnail']['tmp_name'],"../Thumbnails/".$cosha."/".$cosha.".jpg");
		}elseif ($_FILES['thumbnail']['type'] == 'image/png') {
			move_uploaded_file($_FILES['thumbnail']['tmp_name'],"../Thumbnails/".$cosha."/".$cosha.".png");
		}
	}	
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "mascharm") {
	$generado = $_POST['generado'];
		print_r($_FILES['mascharmfile']["type"]);
		if (is_dir('../TemporalMasCharm/'.$generado)) {
			rmdir_recurse('../TemporalMasCharm/'.$generado);
			mkdir('../TemporalMasCharm/'.$generado);
			if ($_FILES['mascharmfile']['type'] ==='image/jpeg') {
				move_uploaded_file($_FILES['mascharmfile']['tmp_name'],'../TemporalMasCharm/'.$generado.'/'.$generado.'.jpg');
			}else{
				move_uploaded_file($_FILES['mascharmfile']['tmp_name'],'../TemporalMasCharm/'.$generado.'/'.$generado.'.png');
			}		
		}else{
			mkdir('../TemporalMasCharm/'.$generado);
			if ($_FILES['mascharmfile']['type'] ==='image/jpeg') {
				move_uploaded_file($_FILES['mascharmfile']['tmp_name'],'../TemporalMasCharm/'.$generado.'/'.$generado.'.jpg');
			}else{
				move_uploaded_file($_FILES['mascharmfile']['tmp_name'],'../TemporalMasCharm/'.$generado.'/'.$generado.'.png');
			}
		}
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "updatecharm") {
	$generado = $_POST['generado'];
			print_r($_FILES['mascharmupdatefile']["type"]);
			if (is_dir('../MasCharm/'.$generado)) {
				rmdir_recurse('../MasCharm/'.$generado);
				mkdir('../MasCharm/'.$generado);
				if ($_FILES['mascharmupdatefile']['type'] ==='image/jpeg') {
					move_uploaded_file($_FILES['mascharmupdatefile']['tmp_name'],'../MasCharm/'.$generado.'/'.$generado.'.jpg');
				}else{
					move_uploaded_file($_FILES['mascharmupdatefile']['tmp_name'],'../MasCharm/'.$generado.'/'.$generado.'.png');
				}		
			}else{
				mkdir('../MasCharm/'.$generado);
				if ($_FILES['mascharmupdatefile']['type'] ==='image/jpeg') {
					move_uploaded_file($_FILES['mascharmupdatefile']['tmp_name'],'../MasCharm/'.$generado.'/'.$generado.'.jpg');
				}else{
					move_uploaded_file($_FILES['mascharmupdatefile']['tmp_name'],'../MasCharm/'.$generado.'/'.$generado.'.png');
				}
			}	
}elseif (isset($receiver) && $receiver == "update") {
	$id = $_POST['articulo_id'];

	$art = new stdClass;
	$art->articulo_id = $id;
	$art->titulo = $_POST['titulo'];
	$art->subtitulo = $_POST['subtitulo'];
	$art->contenido = $_POST['contenido'];
	$art->status = $_POST['status'];
	$art->medio = $_POST['medio'];
	$art->tags = $_POST['tags'];
	$art->tipo = $_POST['tipo'];
	$art->colaborador_id = $_POST['colaboradores'];
	$art->seccion_id = $_POST['secciones'];
	$art->video = $_POST['video'];	
	if (strlen($_POST['fecha']) == 0) {
			$art->mes = date('m');
			$art->dia = date('d');
			$art->year = date('Y');			
	}else{
		$fechaexplotada = explode("/",$_POST['fecha']);
		$art->mes = $fechaexplotada[0];
		$art->dia = $fechaexplotada[1];
		$art->year = $fechaexplotada[2];
	}

	if ($art->tipo == "2") {
		$articleDao->updateVideoUrl($art);
	}
	$articleDao->updateArticulo($art);
	$articleDao->updateTags($art);
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "damedelmes") {
	$delmes = $articleDao->getRandomOfTheMonth();
	echo json_encode($delmes);
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "damedelasemana") {
	$delasemana = $articleDao->getRandomOfTheSemaine();
	echo json_encode($delasemana);
}elseif (isset($_POST['receiver']) && $_POST['receiver'] == "damedelaprevios") {
	$delaprevious = $articleDao->getRandomPrevious();
	echo json_encode($delaprevious);
}else{
	echo json_encode($articleDao->getArticulos());
}
?>