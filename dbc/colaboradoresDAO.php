<?php
class colaboradoresDAO{
	private $dbc;
	public function  __construct($connection)
	{
		$this->dbc = $connection;
	}
	
	public function getColaboradores(){
		$q = "SELECT colaborador_id as 'id', CONCAT(colaboradores.nombre, ' ' ,colaboradores.apellido) as 'nombrec', colaboradores.nombre , colaboradores.apellido, giro, twitter, tipo, medio, imagen, descripcion, link_extra, plaza_id FROM colaboradores ORDER BY colaboradores.apellido DESC";
		$array = array();
		$r = $this->dbc-> query($q);
		while ($obj = $r->fetch_object()) {
			/*Get Secciones del Colaborador*/
			// $obj->plaza = getPlaza($obj->plaza_id);
			// $obj->secciones = $this->getSeccionesColaborador($obj->id);
			$array[] = $obj;
		}
		return $array;
	}
	
	public function getColaborador($id){
		$q = "SELECT colaborador_id, CONCAT(colaboradores.nombre, ' ' ,colaboradores.apellido) as 'nombrec', colaboradores.nombre, colaboradores.apellido, giro, twitter, tipo, medio, imagen, descripcion, link_extra, plaza_id  FROM colaboradores WHERE colaborador_id = ?";
		$stmt = $this->dbc->stmt_init();
		$obj = new stdClass;
		if($stmt->prepare($q)) {
 			$stmt->bind_param('i', $id);
 			$stmt->execute();
 			$stmt->bind_result($colaborador_id,$nombrec, $nombre, $apellido, $giro, $twitter, $tipo, $medio, $imagen, $descripcion, $link_extra, $plaza_id);
 			while($stmt->fetch()){
 				$obj->id = $colaborador_id;
 				$obj->nombre = $nombre;
 				$obj->nombrec = $nombrec;
 				$obj->apellido = $apellido;
 				$obj->giro = $giro;
 				$obj->twitter = $twitter;
 				$obj->tipo = $tipo;
 				$obj->medio = $medio;
 				$obj->plaza_id = $plaza_id;
 				$obj->imagen = $imagen;
 				$obj->descripcion = $descripcion;
 				$obj->link_extra = $link_extra;
 			}
 			$stmt->close();
 		}
 		return $obj;
	}

	public function getColaboradoresFrom($from, $to){
		$array = array();
		$q = "SELECT colaborador_id, colaboradores.nombre, colaboradores.apellido, giro, twitter, tipo, medio, imagen, descripcion, link_extra, plaza_id  FROM colaboradores WHERE colaboradores.apellido > ? AND colaboradores.apellido <= ? ORDER BY apellido";
		$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
 			$stmt->bind_param('ss', $from, $to);
 			$stmt->execute();
 			$stmt->bind_result($colaborador_id, $nombre, $apellido, $giro, $twitter, $tipo, $medio, $imagen, $descripcion, $link_extra, $plaza_id);
 			while($stmt->fetch()){
 				$obj = new stdClass;
 				$obj->colaborador_id = $colaborador_id;
 				$obj->nombre = $nombre;
 				$obj->apellido = $apellido;
 				$obj->giro = $giro;
 				$obj->twitter = $twitter;
 				$obj->tipo = $tipo;
 				$obj->medio = $medio;
 				$obj->plaza_id = $plaza_id;
 				$obj->plaza = getPlaza($obj->plaza_id);
 				$obj->imagen = $imagen;
 				$obj->descripcion = $descripcion;
 				$obj->link_extra = $link_extra;
 				$array[] = $obj;
 			}
 			$stmt->close();
 		}
 		return $array;
	}

	public function getSeccionesColaborador($id){
		$array = array();
		$q = "SELECT colaboradores_secciones.seccion_id, secciones.nombre as 'seccion'FROM colaboradores_secciones JOIN secciones ON secciones.seccion_id =  colaboradores_secciones.seccion_id WHERE colaboradores_secciones.colaborador_id = ?";
		$stmt = $this->dbc->stmt_init();	
		if($stmt->prepare($q)) {
 			$stmt->bind_param('i', $id);
 			$stmt->execute();
 			$stmt->bind_result($seccion_id, $seccion);
 			while($stmt->fetch()){
 				$obj = new stdClass;
 				$obj->seccion_id = $seccion_id;
 				$obj->seccion = $seccion;
 				$array[] = $obj;
 			}
 			$stmt->close();
 		}
 		return $array;
	}
	
	public function insertColaborador($obj){
		$q = "INSERT INTO colaboradores (nombre, apellido,  giro, twitter, tipo, medio, descripcion, link_extra, imagen, plaza_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $this->dbc->stmt_init();
 		if($stmt->prepare($q)) {
 			$stmt->bind_param('ssssssssss', $obj->nombre, $obj->apellido, $obj->giro, $obj->twitter, $obj->tipo, $obj->medio, $obj->descripcion, $obj->link_extra, $obj->imagen, $obj->plaza_id);
 			$stmt->execute();
 		}
 		$id = $this->dbc->insert_id;
		$stmt->close();
		return $id;
	}
	
	public function insertColaboradorSecciones($seccion_id, $colaborador_id){
		$q = "INSERT INTO colaboradores_secciones (seccion_id, colaborador_id) VALUES (?, ?)";
		$stmt = $this->dbc->stmt_init();
 		if($stmt->prepare($q)) {
 			$stmt->bind_param('ii', $seccion_id, $colaborador_id);
 			$stmt->execute();
 		}
 		$id = $this->dbc->insert_id;
		$stmt->close();
		return $id;
	}
	
	public function updateColaborador($obj){
		$q = "UPDATE colaboradores SET nombre = ?, apellido = ?, giro = ?, twitter = ?, tipo = ?, medio = ?, descripcion = ?, link_extra = ?, imagen = ?, plaza_id = ? WHERE colaborador_id = ?";
		$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('sssssssssss', $obj->nombre, $obj->apellido,  $obj->giro, $obj->twitter, $obj->tipo, $obj->medio, $obj->descripcion, $obj->link_extra, $obj->imagen, $obj->plaza_id, $obj->id);
			$stmt->execute();
		}
		$stmt->close();
		return $obj;
	}
	
	public function updateColaboradorSecciones($seccion_id, $colaborador_id){
		$q = "UPDATE colaboradores_secciones SET seccion_id = ? WHERE colaborador_id = ?";
		$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('ii', $seccion_id, $colaborador_id);
			$stmt->execute();
		}
		$stmt->close();
		return $obj;
	}
	
	public function deleteColaborador($id){
		$q = "DELETE FROM colaboradores WHERE colaborador_id = ?";
		$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
		}
		$stmt->close();
	}
	
	public function deleteColaboradorSecciones($id){
		$q = "DELETE FROM colaboradores_secciones WHERE colaborador_id = ?";
		$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
		}
		$stmt->close();
	}	
		
} ?>
