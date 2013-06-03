<?php 
class areasDAO{
private $dbc;
public function  __construct($connection)
{
	$this->dbc = $connection;
}

public function getAreas(){
	$q = "SELECT area_id as 'id', nombre FROM areas";
	$array = array();
	$r = $this->dbc-> query($q);
	while ($obj = $r->fetch_object()) {
		$array[] = $obj;
	}

	return $array;
}

public function insertArea($obj){
	$q = "INSERT INTO areas (nombre) VALUES (?)";
	$stmt = $this->dbc->stmt_init();
	if($stmt->prepare($q)) {
		$stmt->bind_param('s', $obj->nombre);
		$stmt->execute();
	}
	$id = $this->dbc->insert_id;
	$stmt->close();
	return $id;
}


public function updateArea($obj){
	$q = "UPDATE areas SET nombre = ? WHERE area_id = ?";
	$stmt = $this->dbc->stmt_init();
	if($stmt->prepare($q)) {
		$stmt->bind_param('ss', $obj->nombre, $obj->id);
		$stmt->execute();
	}
	$stmt->close();
	return $obj;
}

public function deleteArea($id){
	$q = "DELETE FROM areas WHERE area_id = ?";
	$stmt = $this->dbc->stmt_init();
	if($stmt->prepare($q)) {
		$stmt->bind_param('i', $id);
		$stmt->execute();
	}
	$stmt->close();
}

public function getAreaByNombre($nombre){
	$q = "SELECT area_id, nombre FROM areas WHERE nombre = ?";
	$stmt = $this->dbc->stmt_init();
		$obj = new stdClass;
		if($stmt->prepare($q)) {
 			$stmt->bind_param('s', $nombre);
 			$stmt->execute();
 			$stmt->bind_result($area_id, $nombre);
 			while($stmt->fetch()){
 				$obj->area_id = $area_id;
 				$obj->nombre = $nombre;
 			}
 			$stmt->close();
 		}
 		return $obj;
}

public function getAreaById($id){
	$q = "SELECT area_id, nombre FROM areas WHERE area_id = ?";
	$stmt = $this->dbc->stmt_init();
		$obj = new stdClass;
		if($stmt->prepare($q)) {
 			$stmt->bind_param('i', $id);
 			$stmt->execute();
 			$stmt->bind_result($area_id, $nombre);
 			while($stmt->fetch()){
 				$obj->area_id = $area_id;
 				$obj->nombre = $nombre;
 			}
 			$stmt->close();
 		}
 		return $obj;
}

public function getAreasExcept($id){
	$array = array();
	$q = "SELECT area_id, nombre FROM areas WHERE area_id != ?";
	$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
 			$stmt->bind_param('i', $id);
 			$stmt->execute();
 			$stmt->bind_result($area_id, $nombre);
 			while($stmt->fetch()){
 				$obj = new stdClass;
 				$obj->area_id = $area_id;
 				$obj->nombre = $nombre;
 				$array[] = $obj;
 			}
 			$stmt->close();
 		}
 		return $array;
}

}
?>