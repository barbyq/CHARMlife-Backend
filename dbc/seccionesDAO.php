<?php
class seccionesDAO{
	private $dbc;

	public function  __construct($connection)
	{
		$this->dbc = $connection;
	}

	public function getSecciones(){
		$q = "SELECT seccion_id as 'id', secciones.nombre, secciones.area_id, areas.nombre as 'area' FROM secciones JOIN areas ON secciones.area_id = areas.area_id ORDER BY areas.nombre, secciones.nombre";
		$array = array();
		$r = $this->dbc-> query($q);
		while ($obj = $r->fetch_object()) {
			$array[] = $obj;
		}
		return $array;
	}

	public function getSeccionByNombre($nombre){
	$q = "SELECT seccion_id, secciones.nombre, secciones.area_id, areas.nombre as 'area' FROM secciones JOIN areas ON secciones.area_id = areas.area_id WHERE secciones.nombre = ?";
	$stmt = $this->dbc->stmt_init();
		$obj = new stdClass;
		if($stmt->prepare($q)) {
 			$stmt->bind_param('s', $nombre);
 			$stmt->execute();
 			$stmt->bind_result($seccion_id, $nombre, $area_id, $area);
 			while($stmt->fetch()){
 				$obj->seccion_id = $seccion_id;
 				$obj->nombre = $nombre;
 				$obj->area_id = $area_id;
 				$obj->area = $area;
 			}
 			$stmt->close();
 		}
 		return $obj;
}

public function getSeccionById($id){
	$q = "SELECT seccion_id, secciones.nombre, secciones.area_id, areas.nombre as 'area' FROM secciones JOIN areas ON secciones.area_id = areas.area_id WHERE secciones.seccion_id = ?";
	$stmt = $this->dbc->stmt_init();
		$obj = new stdClass;
		if($stmt->prepare($q)) {
 			$stmt->bind_param('i', $id);
 			$stmt->execute();
 			$stmt->bind_result($seccion_id, $nombre, $area_id, $area);
 			while($stmt->fetch()){
 				$obj->seccion_id = $seccion_id;
 				$obj->nombre = $nombre;
 				$obj->area_id = $area_id;
 				$obj->area = $area;
 			}
 			$stmt->close();
 		}
 		return $obj;
}

public function getSeccionesByArea($area_id){
	$q = "SELECT seccion_id, secciones.nombre, secciones.area_id, areas.nombre as 'area' FROM secciones JOIN areas ON secciones.area_id = areas.area_id WHERE secciones.area_id = ?";
	$stmt = $this->dbc->stmt_init();
	$array = array();
		
		if($stmt->prepare($q)) {
 			$stmt->bind_param('i', $area_id);
 			$stmt->execute();
 			$stmt->bind_result($seccion_id, $nombre, $area_id, $area);
 			while($stmt->fetch()){
 				$obj = new stdClass;
 				$obj->seccion_id = $seccion_id;
 				$obj->nombre = $nombre;
 				$obj->area_id = $area_id;
 				$obj->area = $area;
 				$array[] = $obj;
 			}
 			$stmt->close();
 		}
 		return $array;
}

	/*public function getAreaSeccion($id){
		$array = array();
		$q = "SELECT seccion_id as 'id', secciones.nombre, secciones.area_id, areas.nombre as 'area' FROM secciones JOIN areas ON secciones.area_id = areas.area_id WHERE seccion_id = ?";
		$stmt = $this->dbc->stmt_init();	
		if($stmt->prepare($q)) {
 			$stmt->bind_param('i', $id);
 			$stmt->execute();
 			$stmt->bind_result($seccion_id, $nombre, $area_id, $area);
 			while($stmt->fetch()){
 				$obj = new stdClass;
 				$obj->id = $seccion_id;
 				$obj->nombre = $nombre;
 				$obj->area_id = $area_id;
 				$obj->area = $area;
 				$array[] = $obj;
 			}
 			$stmt->close();
 		}
 		return $array;
	}*/

	public function insertSeccion($obj){
		$q = "INSERT INTO secciones (nombre, area_id) VALUES (?, ?)";
		$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('ss', $obj->nombre, $obj->area_id);
			$stmt->execute();
		}
		$id = $this->dbc->insert_id;
		$stmt->close();
		return $id;
	}

	public function updateSeccion($obj){
		$q = "UPDATE secciones SET nombre = ? , area_id = ? WHERE seccion_id = ?";
		$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('sss', $obj->nombre, $obj->area_id, $obj->id);
			$stmt->execute();
		}
		$stmt->close();
		return $obj;
	}

	public function deleteSeccion($id){
		$q = "DELETE FROM secciones WHERE seccion_id = ?";
		$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
		}
		$stmt->close();
	}
}
?>