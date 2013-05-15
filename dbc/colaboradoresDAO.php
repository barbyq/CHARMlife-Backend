<?php 

/**
 * 
 */
 class colaboradoresDAO
 {
 	private $dbc;
 	function __construct($con)
 	{
 		$this->dbc = $con;
 	}

 	public function getColaboradoresNombres()
 	{
 		$arrery = array();
 		$busqueda = "SELECT colaborador_id, CONCAT(nombre,' ',apellido) as 'nombre' from colaboradores";
 		$queonda = $this->dbc->query($busqueda);
 		while ($kepo = $queonda->fetch_object()) {
 			$arrery[] = $kepo;
 		}
 		return $arrery;
 	}
 } ?>