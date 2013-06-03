<?php
class chismesDAO{
	private $dbc;

	public function __construct($connection){
		$this->dbc = $connection;
	}

	public function getChismes(){
		$q = "SELECT id, fecha, titulo, texto, link, foto FROM chismes";
		$array = array();
		$r = $this->dbc-> query($q);
		while ($obj = $r->fetch_object()) {
			$array[] = $obj;
		}
		return $array;
	} 

	public function getChismeById($id){
		$q = "SELECT id, fecha, titulo, texto, link, foto FROM chismes WHERE id = ?";
		$stmt = $this->dbc->stmt_init();
		$obj = new stdClass;
		if($stmt->prepare($q)) {
 			$stmt->bind_param('i', $id);
 			$stmt->execute();
 			$stmt->bind_result($id, $fecha, $titulo,$texto,$link,$foto);
 			while($stmt->fetch()){
 				$obj->id = $id;
 				$obj->fecha = $fecha;
 				$obj->titulo = $titulo;
 				$obj->texto = $texto;
 				$obj->link = $link;
 				$obj->foto = $foto;
 			}
 			$stmt->close();
 		}
 		return $obj;
	}

	public function insertChisme($obj){
		$q = "INSERT INTO chismes (fecha, titulo, texto, link, foto) VALUES (?, ?, ?, ?, ?)";
		$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('sssss', $obj->fecha, $obj->titulo, $obj->texto, $obj->link, $obj->foto);
			$stmt->execute();
		}
		$id = $this->dbc->insert_id;
		$stmt->close();
		return $id;	
	}

	public function updateChisme($obj){
		$q = "UPDATE chismes SET fecha = ? , titulo = ?, texto = ? , link = ?, foto = ? WHERE id = ?";
		$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('sssssi', $obj->fecha, $obj->titulo, $obj->texto, $obj->link, $obj->foto, $obj->id);
			$stmt->execute();
		}
		$stmt->close();
		return $obj;
	}

	public function deleteChisme($id){
		$q = "DELETE FROM chismes WHERE id = ?";
		$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
		}
		$stmt->close();
	}
}
?>