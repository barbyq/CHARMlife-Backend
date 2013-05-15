<?php 
/**
 * 
 */
 class seccionesDAO
 {
 	private $dbc;

 	function __construct($con)
 	{
 		$this->dbc = $con;
 	}

 	public function getSecciones()
 	{
 		$y = "SELECT * from secciones";
 		return 0;
 	}
 } ?>