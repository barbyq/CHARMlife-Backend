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


	public function getArticulo($id)
	{
		$busq = "SELECT articulos.articulo_id, articulos.titulo, articulos.dia,articulos.mes,articulos.year,articulos.status,articulos.tipo, articulos.contenido, CONCAT(colaboradores.nombre,' ',colaboradores.apellido) as 'colaborador_id',usuarios.nombre as 'usuario_id', secciones.nombre as 'seccion_id', articulos.subtitulo from articulos join colaboradores on articulos.colaborador_id = colaboradores.colaborador_id join usuarios on articulos.usuario_id = usuarios.usuario_id join secciones on articulos.seccion_id = secciones.seccion_id where articulo_id = ?";
		$ye = $this->dbc->stmt_init();
		$articulo = new stdClass;
		if ($ye->prepare($busq)) {
			$ye->bind_param('i',$id);
			$ye->execute();
			$ye->bind_result($articulo_id,$titulo,$dia,$mes,$year,$status,$tipo,$contenido,$colaborador,$usuario_id,$seccion_id,$subtitulo);
			while ($ye->fetch()) {
				$articulo->articulo_id = $articulo_id;
				$articulo->titulo = $titulo;
				$articulo->subtitulo = $subtitulo;
				$articulo->dia = $dia;
				$articulo->mes = $mes;
				$articulo->year = $year;
				$articulo->status = $status;
				$articulo->tipo = $tipo;
				$articulo->contenido = $contenido;
				$articulo->colaborador_id = $colaborador;
				$articulo->usuario_id = $usuario_id;
				$articulo->seccion_id = $seccion_id;
			}
		}
		return $articulo;
	}

	public function getLastArticulos()
	{
		$s = "SELECT articulo_id,titulo,subtitulo,dia,mes,year,status,tipo,contenido,colaborador_id,usuario_id,seccion_id from articulos where status = 0 order by articulo_id desc limit 12; ";
		$blepo = $this->dbc->stmt_init();
		$a = array();
		if ($blepo->prepare($s)) {
			$blepo->execute();
			$blepo->bind_result($articulo_id,$titulo,$subtitulo,$dia,$mes,$year,$status,$tipo,$contenido,$colaborador,$usuario_id,$seccion_id);
			while ($blepo->fetch()) {
				$nuevo = new stdClass;
				$nuevo->articulo_id = $articulo_id;
				$nuevo->titulo = $titulo;
				$nuevo->subtitulo = $subtitulo;
				$nuevo->dia = $dia;
				$nuevo->mes = $mes;
				$nuevo->year = $year;
				$nuevo->status = $status;
				$nuevo->tipo = $tipo;
				$nuevo->contenido = $contenido;
				$nuevo->colaborador_id = $colaborador;
				$nuevo->usuario_id = $usuario_id;
				$nuevo->seccion_id = $seccion_id;
				$a[] = $nuevo;
			}
		}
		return $a;
	}

	public function getArticuloForReal($id)
	{
		$busq = "SELECT articulo_id,titulo,subtitulo,dia,mes,year,status,tipo,contenido,colaborador_id,usuario_id,seccion_id from articulos where articulo_id = ? and status = 0";
		$ye = $this->dbc->stmt_init();
		$articulo = new stdClass;
		if ($ye->prepare($busq)) {
			$ye->bind_param('i',$id);
			$ye->execute();
			$ye->bind_result($articulo_id,$titulo,$subtitulo,$dia,$mes,$year,$status,$tipo,$contenido,$colaborador,$usuario_id,$seccion_id);
			while ($ye->fetch()) {
				$articulo->articulo_id = $articulo_id;
				$articulo->titulo = $titulo;
				$articulo->subtitulo = $subtitulo;
				$articulo->dia = $dia;
				$articulo->mes = $mes;
				$articulo->year = $year;
				$articulo->status = $status;
				$articulo->tipo = $tipo;
				$articulo->contenido = $contenido;
				$articulo->colaborador_id = $colaborador;
				$articulo->usuario_id = $usuario_id;
				$articulo->seccion_id = $seccion_id;
			}
		}
		return $articulo;	
	}

	public function getArticulos()
	{
		$articulos = array();
		$holaquetal = "SELECT articulos.articulo_id, articulos.titulo, articulos.dia,articulos.mes,articulos.year,articulos.status,articulos.tipo, CONCAT(colaboradores.nombre,' ',colaboradores.apellido) as 'colaborador_id',usuarios.nombre as 'usuario_id', secciones.nombre as 'seccion_id', articulos.subtitulo from articulos join colaboradores on articulos.colaborador_id = colaboradores.colaborador_id join usuarios on articulos.usuario_id = usuarios.usuario_id join secciones on articulos.seccion_id = secciones.seccion_id";
		$yim = $this->dbc->query($holaquetal);
		while ($artip = $yim->fetch_object()) {
			$articulos[] = $artip;
		}
		return $articulos;
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

	public function updateArticulo($articulo)
	{
		$yep = "UPDATE articulos set contenido = ?, subtitulo = ?, year = ?,mes = ?, dia = ?, colaborador_id = ?, seccion_id = ?, status = ?, tipo = ?, titulo = ? where articulo_id = ?";
		$ti = $this->dbc->stmt_init();
		if ($ti->prepare($yep)) {
			$ti->bind_param("ssiiiiiiisi",$articulo->contenido,$articulo->subtitulo,$articulo->year,$articulo->mes,$articulo->dia,$articulo->colaborador_id,$articulo->seccion_id,$articulo->status,$articulo->tipo,$articulo->titulo,$articulo->articulo_id);
			$ti->execute();
		}

	}

	public function deleteArticulo($id)
	{
		$deleti = "DELETE FROM articulos where articulo_id = ?";
		$sky = $this->dbc->stmt_init();
		if ($sky->prepare($deleti)) {
			$sky->bind_param("i",$id);			
			$sky->execute();
		}		
	}

	public function getArticuloTags($id)
	{
		$tagsotes = array();
		$stto = "SELECT tag FROM tags where articulo_id = ?";
		$exe = $this->dbc->stmt_init();
		if ($exe->prepare($stto)) {
			$exe->bind_param('i',$id);
			$exe->execute();
			$exe->bind_result($tag);
			while ($exe->fetch()) {
				$tagsotes[] = $tag;			
			}		
		}
		return $tagsotes;
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


	public function updateTags($articulo)
	{
		$primero = "DELETE FROM tags where articulo_id = ?";
		$yep = $this->dbc->stmt_init();
		if ($yep->prepare($primero)) {
			$yep->bind_param("i",$articulo->articulo_id);
			$yep->execute();
		}
		$yep->close();

		$aidi = $articulo->articulo_id;
		$busqueda = "INSERT into tags(tag,articulo_id) values(?,?)";
		$estatutote = $this->dbc->stmt_init();	
		$arreglodetags = explode(',', $articulo->tags);
		foreach ($arreglodetags as $tag) {
			$trimeado = trim($tag);
			if (strlen($trimeado) != 0){
				if ($estatutote->prepare($busqueda)) {
					$estatutote->bind_param('si', $trimeado,$aidi);
					$estatutote->execute();
				}
			}	
		}
	}

	public function deleteArticuloTags($id)
	{
		$k = "DELETE FROM tags where articulo_id = ?";
		$h = $this->dbc->stmt_init();
		if ($h->prepare($k)) {
			$h->bind_param("i",$id);
			$h->execute();
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

	public function deleteArticuloMedia($id)
	{
		$e = "DELETE FROM articulo_media where articulo_id = ?";
		$s = $this->dbc->stmt_init();
		if ($s->prepare($e)) {
			$s->bind_param("i",$id);
			$s->execute();
		}
	}
	
	public function dameurlvid($vidi)
	{
		$url = "";
		$kecosa = "SELECT video_url from articulo_media where articulo_id = ?";
		$estat = $this->dbc->stmt_init();
		if ($estat->prepare($kecosa)) {
			$estat->bind_param('i',$vidi);
			$estat->execute();
			$estat->bind_result($coshi);
			while ($estat->fetch()) {
				$url = $coshi;
			}
		}
		return $url;
	}

	public function updateVideoUrl($arti)
	{
		$busqueda = "UPDATE articulo_media set video_url = ? where articulo_id = ?";
		$ti = $this->dbc->stmt_init();
		if ($ti->prepare($busqueda)) {
			$ti->bind_param("si",$arti->video,$arti->articulo_id);
			$ti->execute();
		}
	}

	public function getArticulosMinByColaborador($idcolab)
	{
		$articulos = array();
		$busqueda = "SELECT articulo_id,titulo, subtitulo from articulos where colaborador_id = ? and status = 0";
		$es = $this->dbc->stmt_init();
		if ($es->prepare($busqueda)) {
			$es->bind_param("i",$idcolab);
			$es->execute();
			$es->bind_result($articulo_id,$titulo,$subtitulo);
			while ($es->fetch()) {
				$articulo = new stdClass;
				$articulo->articulo_id = $articulo_id;
				$articulo->titulo = $titulo;
				$articulo->subtitulo = $subtitulo;
				$articulos[] = $articulo;
			}
		}
		return $articulos;
	}

	public function getArticulosByColaboradorByInterval($colaborador,$interval)
	{
		$yepmn = array();
		$ble = "SELECT articulo_id,titulo, subtitulo from articulos where colaborador_id = ? and status = 0 order by articulo_id asc limit ?,8";
		$estta = $this->dbc->stmt_init();
		if ($estta->prepare($ble)) {
			$estta->bind_param("ii",$colaborador,$interval);
			$estta->execute();
			$estta->bind_result($articulo_id,$titulo,$subtitulo);
			while ($estta->fetch()) {
				$artip = new stdClass;
				$artip->articulo_id = $articulo_id;
				$artip->titulo = $titulo;
				$artip->substitulo = $subtitulo;
				$yepmn[] = $artip;
			}
		}
		return $yepmn;
	}

	public function getRandomOfTheMonth()
	{
		$mes = date('n');
		$busqueda = "SELECT articulo_id,titulo, subtitulo from articulos where mes = ? and status = 0 ORDER BY rand() LIMIT 12";
		$kepo = $this->dbc->stmt_init();
		$rreiglo = array();
		if ($kepo->prepare($busqueda)) {
			$kepo->bind_param("i", $mes);
			$kepo->execute();
			$kepo->bind_result($articulo_id,$titulo,$subtitulo)	;
			while ($kepo->fetch()) {
				$art = new stdClass;
				$art->articulo_id = $articulo_id;
				$art->titulo = $titulo;		
				$art->subtitulo = $subtitulo;
				$rreiglo[] = $art;
			}		
		}
		return $rreiglo;		
	}

	public function getRandomOftheSemaine()
	{
		# code...
	}
}
 ?>