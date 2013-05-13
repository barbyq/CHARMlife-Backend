
<?php
class amigosDAO{
	private $dbc;

	public function  __construct($connection)
	{
		$this->dbc = $connection;
	}

	public function getAmigos(){
		$q = "SELECT id, tipo, posicion, texto, img FROM amigos_redes";
		$array = array();
		$r = $this->dbc-> query($q);
		while ($obj = $r->fetch_object()) {
			$array[] = $obj;
		}
		return $array;
	}


	public function getAmigoById(){
		$q = "SELECT id, tipo, posicion, texto, img FROM amigos_redes WHERE id = ?";
		$stmt = $this->dbc->stmt_init();
		$obj = new stdClass;
		if($stmt->prepare($q)) {
 			$stmt->bind_param('i', $id);
 			$stmt->execute();
 			$stmt->bind_result($id, $tipo, $posicion, $texto, $img);
 			while($stmt->fetch()){
 				$obj->id = $id;
 				$obj->tipo = $tipo;
 				$obj->posicion = $posicion;
 				$obj->texto = $texto;
 				$obj->img = $img;
 			}
 			$stmt->close();
 		}
 		return $obj;
	}



} ?>