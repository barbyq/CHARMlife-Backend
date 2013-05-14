<?php 

/**
 * 
 */
class articulosDAO
{
	private $dbc;

	function __construct($con)
	{
		$this->dbc = $con;
	}

	public function getArticulos()
	{
		$articulos = array();
		$holaquetal = "SELECT articulo_id,titulo,subtitulo,dia,mes,year,colaborador_id,seccion_id,usuario_id,status,tipo from articulos";
		$yim = $this->dbc->query($holaquetal);
		while ($artip = $yim->fetch_object()) {
			$articulos[] = $artip;
		}
		return $articulos;
	}

	public function getArticulo($id)
	{
		return 0;
	}

	public function insertArticulo($articulo)
	{
		
	}

	public function editArticulo($articulo)
	{
		
	}

	public function deleteArticulo()
	{
		
	}
}
 ?>