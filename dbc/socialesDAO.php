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
	$q = "SELECT sociales_id, titulo, subtitulo, fecha, descripcion, compartido, recomendado, visto,status  FROM sociales WHERE sociales_id = ? ORDER BY fecha DESC ";
	$stmt = $this->dbc->stmt_init();
		$obj = new stdClass;
		if($stmt->prepare($q)) {
 			$stmt->bind_param('s', $id);
 			$stmt->execute();
 			$stmt->bind_result($sociales_id, $titulo, $subtitulo, $fecha, $descripcion, $compartido, $recomendado, $visto,$status);
 			while($stmt->fetch()){
 				$obj->sociales_id = $sociales_id;
 				$obj->titulo = $titulo;
 				$obj->subtitulo = $subtitulo;
 				$obj->fecha = $fecha;
 				$obj->descripcion = $descripcion;
 				$obj->compartido = $compartido;
 				$obj->recomendado = $recomendado;
 				$obj->visto = $visto;
 				$obj->status = $status;
 			}
 			$stmt->close();
 		}
 		return $obj;
}


public function insertSocial($obj){
	$q = "INSERT INTO sociales (titulo, subtitulo, fecha, descripcion, usuario_id,status) VALUES(?,?,?,?,?,?)";
	$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('sssssi', $obj->titulo, $obj->subtitulo, $obj->fecha, $obj->descripcion, $obj->usuario_id,$obj->status);
			$stmt->execute();
		}
		$id = $this->dbc->insert_id;
		$stmt->close();
	return $id;
}

public function updateSocial($obj){
	$q = "UPDATE sociales SET titulo = ? , subtitulo = ?, fecha = ?, descripcion = ?, usuario_id = ?,status = ? WHERE sociales_id = ?";
		$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('ssssiii', $obj->titulo, $obj->subtitulo, $obj->fecha, $obj->descripcion, $obj->usuario_id,$obj->status,$obj->sociales_id);
			$stmt->execute();
		}
		$stmt->close();
		return $obj;
}

public function deleteSocial($obj){
	$q = "DELETE FROM sociales WHERE sociales_id = ?";
		$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('s', $obj->sociales_id);
			$stmt->execute();
		}
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

public function getImagenesbySocialId($id)
{
	$arregl = array();
	$comida = "SELECT fotos_id,descripcion,img from fotos where sociales_id = ?";
	$s = $this->dbc->stmt_init();
	if ($s->prepare($comida)) {
		$s->bind_param("i",$id);
		$s->execute();
		$s->bind_result($id,$descri,$img);
		while ($s->fetch()) {
			$dim = new stdClass;
			$dim->foto_id = $id;
			$dim->descripcion = $descri;
			$dim->img = $img;
			$arregl[] = $dim;
		}
	}
	return $arregl;
}

public function updateDescripcionFoto($img)
{
	$q = "UPDATE fotos set descripcion = ? where fotos_id = ?";
	$s = $this->dbc->stmt_init();
	if ($s->prepare($q)) {
		$s->bind_param("si",$img->descripcion,$img->id);
		$s->execute();
	}
}

public function deleteFoto($objeto)
{
	$q = "DELETE from fotos where img = ? && sociales_id = ?";
	$s = $this->dbc->stmt_init();
	if ($s->prepare($q)) {
		$s->bind_param("si",$objeto->url,$objeto->sociales_id);
		$s->execute();
	}
}

public function deleteFotosBySocialId($id)
{
	$q = "DELETE FROM fotos where sociales_id = ?";
	$s = $this->dbc->stmt_init();
	if ($s->prepare($q)) {
		$s->bind_param("i",$id);
		$s->execute();
	}
}

}

?>