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
		$holaquetal = "SELECT articulo_id,titulo,subtitulo,dia,mes,year,colaborador_id,seccion_id,usuario_id,status,tipo from articulos";
		$yim = $this->dbc->stmt_init();
		return 0;
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