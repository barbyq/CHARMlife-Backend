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
 		$arr = array();
 		$y = "SELECT * from secciones";
 		$ti = $this->dbc->query($y);
 		while ($aa = $ti->fetch_object()) {
 			$arr[] = $aa;
 		}
 		return $arr;
 	}
 } ?>