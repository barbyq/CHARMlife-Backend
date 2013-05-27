<?php
class socialesDAO{

public function __construct($connection){
	$this->dbc = $connection;
}

public function getSociales(){
	$q = "SELECT sociales_id, titulo, subtitulo, fecha, descripcion, compartido, recomendado, visto  FROM sociales ORDER BY fecha DESC";
	$array = array();
	$r = $this->dbc->query($q);
	while ($obj = $r->fetch_object()) {
			$array[] = $obj;
		}
	return $array;
}

public function getSocialById($id){
	$q = "SELECT sociales_id, titulo, subtitulo, fecha, descripcion, compartido, recomendado, visto  FROM sociales WHERE sociales_id = ? ORDER BY fecha DESC ";
	$stmt = $this->dbc->stmt_init();
		$obj = new stdClass;
		if($stmt->prepare($q)) {
 			$stmt->bind_param('s', $id);
 			$stmt->execute();
 			$stmt->bind_result($sociales_id, $titulo, $subtitulo, $fecha, $descripcion, $compartido, $recomendado, $visto);
 			while($stmt->fetch()){
 				$obj->sociales_id = $sociales_id;
 				$obj->titulo = $titulo;
 				$obj->subtitulo = $subtitulo;
 				$obj->fecha = $fecha;
 				$obj->descripcion = $descripcion;
 				$obj->compartido = $compartido;
 				$obj->recomendado = $recomendado;
 				$obj->visto = $visto;
 			}
 			$stmt->close();
 		}
 		return $obj;
}


public function insertSocial($obj){
	$q = "INSERT INTO sociales (titulo, subtitulo, fecha, descripcion, usuario_id) VALUES(?,?,?,?,?)";
	$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('sssss', $obj->titulo, $obj->subtitulo, $obj->fecha, $obj->descripcion, $obj->usuario_id);
			$stmt->execute();
		}
		$id = $this->dbc->insert_id;
		$stmt->close();
	return $id;
}

public function updateSocial($obj){
	$q = "UPDATE sociales SET titulo = ? , subtitulo = ?, fecha = ?, descripcion = ?, usuario_id = ? WHERE sociales_id = ?";
		$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('ssssss', $obj->titulo, $obj->subtitulo, $obj->fecha, $obj->descripcion, $obj->usuario_id);
			$stmt->execute();
		}
		$stmt->close();
		return $obj;
}

public function deleteSocial($obj){
	$q = "DELETE FROM sociale WHERE sociales_id = ?";
		$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('s', $obj->sociales_id);
			$stmt->execute();
		}
		$stmt->close();
		return $obj;
}

public function insertFoto($foto)
{
	$smn = "INSERT INTO fotos(img,sociales_id) values(?,?)";
	$co = $this->dbc->stmt_init();
	if ($co->prepare($smn)) {
		$co->bind_param("si",$foto->url,$foto->sociales_id);
		$co->execute();
	}
}

public function getFotosOfSocial($id)
{	
	$arr = array();
	$busquedota = "SELECT fotos_id,img from fotos where sociales_id = ?";
	$ye = $this->dbc->stmt_init();

}

}

?>