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
		$holaquetal = "SELECT articulos.articulo_id, articulos.titulo, articulos.dia,articulos.mes,articulos.year,articulos.status,articulos.tipo, CONCAT(colaboradores.nombre,' ',colaboradores.apellido) as 'colaborador_id',usuarios.nombre as 'usuario_id', secciones.nombre as 'seccion_id', articulos.contenido, articulos.subtitulo from articulos join colaboradores on articulos.colaborador_id = colaboradores.colaborador_id join usuarios on articulos.usuario_id = usuarios.usuario_id join secciones on articulos.seccion_id = secciones.seccion_id";
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
		$idgenerado = 0;
		$b = "INSERT INTO articulos(titulo, subtitulo,dia,mes,year,contenido,status,tipo,colaborador_id,seccion_id,usuario_id) values(?,?,?,?,?,?,?,?,?,?,?)";
		$s = $this->dbc->stmt_init();
		if ($s->prepare($b)) {
			$s->bind_param("ssiiisiiiii",$articulo->titulo,$articulo->subtitulo,$articulo->dia,$articulo->mes,$articulo->year,$articulo->contenido,$articulo->status,$articulo->tipo,$articulo->colaborador_id,$articulo->seccion,$articulo->user);
			$s->execute();
		}
		$s->close();
		return mysqli_insert_id($this->dbc);
	}

	public function editArticulo($articulo)
	{
		
	}

	public function deleteArticulo()
	{
		
	}

	public function insertArticuloTags($tags,$articuloidi)
	{
		$arregloidsinsertados = array();
		$busqueda = "INSERT into tags(tag,articulo_id) values(?,?)";
		$estatutote = $this->dbc->stmt_init();	
		$arreglodetags = explode(',', $tags);
		foreach ($arreglodetags as $tag) {
			$trimeado = trim($tag);
			if (strlen($trimeado) != 0){
				if ($estatutote->prepare($busqueda)) {
					$estatutote->bind_param('si', $trimeado,$articuloidi);
					$estatutote->execute();
					$arregloidsinsertados[] = mysqli_insert_id($this->dbc);
				}
			}	
		}
	}

	public function registervideourl($vidi,$idi)
	{
		$cosa = "INSERT INTO articulo_media(video_url,articulo_id) values(?,?)";
		$estatt = $this->dbc->stmt_init();
		if ($estatt->prepare($cosa)) {
			$estatt->bind_param('si',$vidi,$idi);
			$estatt->execute();
		}
	}
}
 ?>