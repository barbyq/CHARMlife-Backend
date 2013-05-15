<?php
class socialesDAO{

public function __construct($connection){
	$this->dbc = $connection;
}

public function getSociales(){
	$q = "SELECT sociales_id, titulo, subtitulo, fecha, descripcion, usuario_id, plaza_id, compartido, recomendado, visto  FROM sociales ORDER BY fecha DESC";
	$array = array();
	$r = $this->dbc->query($q);
	while ($obj = $r->fetch_object()) {
			$array[] = $obj;
		}
	return $array;
}

?>