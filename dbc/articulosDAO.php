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

	public function getArticulosByInterval($int)
	{
		$estata = "SELECT articulo_id,titulo,subtitulo,tipo from articulos where status = 0 order by articulo_id desc limit ?,4;";
		$kepo = $this->dbc->stmt_init();
		$arreglin = array();
		if ($kepo->prepare($estata)) {
			$kepo->bind_param("i", $int);
			$kepo->execute();
			$kepo->bind_result($id,$titulo,$subtitulo,$tipo);
			while ($kepo->fetch()) {
				$nuevacosa = new stdClass;
				$nuevacosa->id = $id;
				$nuevacosa->titulo = $titulo;
				$nuevacosa->subtitulo = $subtitulo;
				$nuevacosa->tipo = $tipo;
				$arreglin[] = $nuevacosa;
			}
		}
		return $arreglin;
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
		foreach ($tags as $tag) {
			$in = "INSERT into tags(articulo_id, tag) values(?,?)";
			$t = $this->dbc->stmt_init();
			if ($t->prepare($in)) {
				$t->bind_param("ii", $articuloidi,$tag);
				$t->execute();
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
		foreach ($articulo->tags as $tag) {
			$blepo = "INSERT into tags(tag, articulo_id) values(?,?)";
			$st = $this->dbc->stmt_init();
			if ($st->prepare($blepo)) {
				$st->bind_param("ii", $tag,$aidi);
				$st->execute();
			}
			$st->close();
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
		$busqueda = "SELECT articulo_id,titulo, subtitulo,tipo from articulos where colaborador_id = ? and status = 0";
		$es = $this->dbc->stmt_init();
		if ($es->prepare($busqueda)) {
			$es->bind_param("i",$idcolab);
			$es->execute();
			$es->bind_result($articulo_id,$titulo,$subtitulo,$tipo);
			while ($es->fetch()) {
				$articulo = new stdClass;
				$articulo->articulo_id = $articulo_id;
				$articulo->titulo = $titulo;
				$articulo->subtitulo = $subtitulo;
				$articulo->tipo = $tipo;
				$articulos[] = $articulo;
			}
		}
		return $articulos;
	}

	public function getArticulosTematicaMensual()
	{
		$st = "SELECT articulo_id, titulo,tipo from articulos where seccion_id in (select seccion_id from secciones where area_id = 7) and status = 0 order by articulo_id desc";
		$mc = $this->dbc->query($st);
		$arreng = array();
		while ($mono = $mc->fetch_object()) {
			$arreng[] = $mono;
		}
		return $arreng;
	}

	public function getArticulosByColaboradorByInterval($colaborador,$interval)
	{
		$yepmn = array();
		$ble = "SELECT articulo_id,titulo, subtitulo,tipo from articulos where colaborador_id = ? and status = 0 order by articulo_id asc limit ?,8";
		$estta = $this->dbc->stmt_init();
		if ($estta->prepare($ble)) {
			$estta->bind_param("ii",$colaborador,$interval);
			$estta->execute();
			$estta->bind_result($articulo_id,$titulo,$subtitulo,$tipo);
			while ($estta->fetch()) {
				$artip = new stdClass;
				$artip->articulo_id = $articulo_id;
				$artip->titulo = $titulo;
				$artip->subtitulo = $subtitulo;
				$artip->tipo = $tipo;
				$yepmn[] = $artip;
			}
		}
		return $yepmn;
	}

	public function getArticulosBySeccion($seccion_id)
	{
		$e = "SELECT articulo_id,titulo,subtitulo,dia,mes,year,status,tipo,contenido,colaborador_id,usuario_id,seccion_id FROM articulos where seccion_id = ?";
		$s = $this->dbc->stmt_init();
		$ti = array();
		if ($s->prepare($e)) {
			$s->bind_param("i", $seccion_id);
			$s->execute();
			$s->bind_result($id,$titulo,$subtitulo,$dia,$mes,$year,$status,$tipo,$contenido,$colaborador_id,$usuario_id,$seccion_id);
			while ($s->fetch()) {
				$novo = new stdClass;
				$novo->articulo_id = $id;
				$novo->titulo = $titulo;
				$novo->subtitulo = $subtitulo;
				$novo->dia = $dia;
				$novo->mes = $mes;
				$novo->year = $year;
				$novo->status = $status;
				$novo->tipo = $tipo;
				$novo->contenido = $contenido;
				$novo->colaborador_id = $colaborador_id;
				$novo->usuario_id = $usuario_id;
				$novo->seccion_id = $seccion_id;
				$ti[] = $novo;
			}
		}
		return $ti;
	}

	public function getLastTematica()
	{
		$bli = "SELECT articulo_id,titulo,subtitulo,dia,mes,year,status,tipo,contenido,colaborador_id,usuario_id,seccion_id from articulos where status = 0 and tipo = 3 order by mes desc, year desc limit 1";
		$ultimo = $this->dbc->query($bli);
		$men = 0;
		if ($mono = $ultimo->fetch_object()) {
			$men = $mono;
		}
		return $men;
	}

	public function getArticulosByArea($area, $limit, $perPage){
		$q = "SELECT articulos.articulo_id, articulos.titulo, articulos.subtitulo, articulos.tipo, mes, dia, year, articulos.colaborador_id, colaboradores.nombre as 'colaboradores', articulos.seccion_id, secciones.nombre as 'secciones' FROM articulos JOIN colaboradores ON articulos.colaborador_id = colaboradores.colaborador_id JOIN secciones ON secciones.seccion_id = articulos.seccion_id JOIN areas ON areas.area_id = secciones.area_id WHERE areas.nombre = ? AND articulos.tipo != 2 AND status = 0 ORDER BY year DESC, mes DESC, dia DESC LIMIT ?, ?";
		$array = array();
		$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('sii', $area,$limit, $perPage);
			$stmt->execute();
			$stmt->bind_result($articulo_id, $titulo, $subtitulo, $tipo, $mes, $dia, $year, $colaborador_id, $colaborador, $seccion_id, $seccion);
			while($stmt->fetch()){
				$obj = new stdClass;
				$obj->articulo_id = $articulo_id;
				$obj->titulo = $titulo;
				$obj->subtitulo = $subtitulo;
				$obj->tipo = $tipo;
				$obj->mes = $mes;
				$obj->dia = $dia;
				$obj->year = $year;
				$obj->colaborador_id = $colaborador_id;
				$obj->colaborador = $colaborador;
				$obj->seccion_id = $seccion_id;
				$obj->seccion = $seccion;
				$array[] = $obj;
			}
			$stmt->close();
		}

		return $array;
	}

	public function getRandomArticulosAndSections()
	{
		$estati = "SELECT articulos.articulo_id, articulos.titulo, articulos.subtitulo, secciones.nombre as 'seccion', articulos.tipo from articulos join secciones on articulos.seccion_id = secciones.seccion_id where status = 0 order by rand() limit 4";
		$ble = $this->dbc->query($estati);
		$arr = array();
		while ($mono = $ble->fetch_object()) {
			$arr[] = $mono;
		}
		return $arr;
	}

	public function getVideosByArea($area, $limit){
		$q = "SELECT articulos.articulo_id, articulos.titulo, articulos.subtitulo, mes, dia, year, articulos.colaborador_id, colaboradores.nombre as 'colaboradores', articulos.seccion_id, secciones.nombre as 'secciones' FROM articulos JOIN colaboradores ON articulos.colaborador_id = colaboradores.colaborador_id JOIN secciones ON secciones.seccion_id = articulos.seccion_id JOIN areas ON areas.area_id = secciones.area_id WHERE areas.nombre = ? AND articulos.tipo = 2 AND status = 0 ORDER BY year DESC, mes DESC, dia DESC LIMIT ?";
		$array = array();
		$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('si', $area,$limit);
			$stmt->execute();
			$stmt->bind_result($articulo_id, $titulo, $subtitulo, $mes, $dia, $year, $colaborador_id, $colaborador, $seccion_id, $seccion);
			while($stmt->fetch()){
				$obj = new stdClass;
				$obj->articulo_id = $articulo_id;
				$obj->titulo = $titulo;
				$obj->subtitulo = $subtitulo;
				$obj->mes = $mes;
				$obj->dia = $dia;
				$obj->year = $year;
				$obj->colaborador_id = $colaborador_id;
				$obj->colaborador = $colaborador;
				$obj->seccion_id = $seccion_id;
				$obj->seccion = $seccion;
				$array[] = $obj;
			}
			$stmt->close();
		}

		return $array;
	}
	public function getMasCharm($limit, $limit2){
		$q = "SELECT articulos.articulo_id, articulos.titulo, articulos.subtitulo, articulos.tipo, mes, dia, year, articulos.colaborador_id, colaboradores.nombre as 'colaboradores', articulos.seccion_id, secciones.nombre as 'secciones' FROM articulos JOIN colaboradores ON articulos.colaborador_id = colaboradores.colaborador_id JOIN secciones ON secciones.seccion_id = articulos.seccion_id JOIN areas ON areas.area_id = secciones.area_id WHERE areas.nombre != 'Personalidades' AND areas.nombre != 'Temática Mensual' AND status = 0 ORDER BY year DESC, mes DESC, dia DESC, articulos.articulo_id DESC LIMIT ?, ?";
		$array = array();
		$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('ii', $limit,$limit2);
			$stmt->execute();
			$stmt->bind_result($articulo_id, $titulo, $subtitulo, $tipo, $mes, $dia, $year, $colaborador_id, $colaborador, $seccion_id, $seccion);
			while($stmt->fetch()){
				$obj = new stdClass;
				$obj->articulo_id = $articulo_id;
				$obj->titulo = $titulo;
				$obj->subtitulo = $subtitulo;
				$obj->tipo = $tipo;
				$obj->mes = $mes;
				$obj->dia = $dia;
				$obj->year = $year;
				$obj->colaborador_id = $colaborador_id;
				$obj->colaborador = $colaborador;
				$obj->seccion_id = $seccion_id;
				$obj->seccion = $seccion;
				$array[] = $obj;
			}
			$stmt->close();
		}

		return $array;
	}

	public function getMasCharmIntereses($tags, $index, $perPage){
		$query_array = array();
		foreach ($tags as $value) {
			$query_array[] = 'tags.tag = ' . $value; 
		}
		$base = "SELECT DISTINCT(articulos.articulo_id), articulos.titulo, articulos.subtitulo, articulos.tipo, mes, dia, year, articulos.colaborador_id, colaboradores.nombre as 'colaboradores', articulos.seccion_id, secciones.nombre as 'secciones' FROM articulos JOIN colaboradores ON articulos.colaborador_id = colaboradores.colaborador_id JOIN secciones ON secciones.seccion_id = articulos.seccion_id JOIN areas ON areas.area_id = secciones.area_id JOIN tags ON articulos.articulo_id = tags.articulo_id WHERE areas.nombre != 'Personalidades' AND areas.nombre != 'Temática Mensual' AND status = 0 AND ( ";
		$q = $base .implode(' OR ', $query_array);
		$end = " ) ORDER BY year DESC, mes DESC, dia DESC LIMIT " . $index . "," . $perPage;
		$q.= $end;
		
	
		$array = array();
		$r = $this->dbc->query($q);
		while ($obj = $r->fetch_object()) {
				$array[] = $obj;
			}
		return $array;
	}

	public function getRandomOfTheMonth()
	{
		$mes = date('n');
		$busqueda = "SELECT articulo_id,titulo, subtitulo, tipo from articulos where  mes = ? and status = 0 ORDER BY rand() LIMIT 12";
		$kepo = $this->dbc->stmt_init();
		$rreiglo = array();
		if ($kepo->prepare($busqueda)) {
			$kepo->bind_param("i", $mes);
			$kepo->execute();
			$kepo->bind_result($articulo_id,$titulo,$subtitulo, $tipo);
			while ($kepo->fetch()) {
				$art = new stdClass;
				$art->articulo_id = $articulo_id;
				$art->titulo = $titulo;		
				$art->subtitulo = $subtitulo;
				$art->tipo = $tipo;
				$rreiglo[] = $art;
			}		
		}
		return $rreiglo;		
	}

	public function getRandomOftheSemaine()
	{
		$mes = date('n');
		$busqueda = "SELECT articulo_id,titulo, subtitulo,tipo from articulos where mes = ? and status = 0 ORDER BY year DESC, mes DESC, dia DESC  LIMIT 12";
		$kepo = $this->dbc->stmt_init();
		$rreiglo = array();
		if ($kepo->prepare($busqueda)) {
			$kepo->bind_param("i", $mes);
			$kepo->execute();
			$kepo->bind_result($articulo_id,$titulo,$subtitulo,$tipo);
			while ($kepo->fetch()) {
				$art = new stdClass;
				$art->articulo_id = $articulo_id;
				$art->titulo = $titulo;		
				$art->subtitulo = $subtitulo;
				$art->tipo = $tipo;
				$rreiglo[] = $art;
			}		
		}
		return $rreiglo;
	}

	public function getRandomPrevious()
	{
		$mes = date('n');
		$busqueda = "SELECT articulo_id,titulo, subtitulo,tipo from articulos where mes != ? and status = 0 ORDER BY rand() LIMIT 12";
		$kepo = $this->dbc->stmt_init();
		$rreiglo = array();
		if ($kepo->prepare($busqueda)) {
			$kepo->bind_param("i", $mes);
			$kepo->execute();
			$kepo->bind_result($articulo_id,$titulo,$subtitulo,$tipo);
			while ($kepo->fetch()) {
				$art = new stdClass;
				$art->articulo_id = $articulo_id;
				$art->titulo = $titulo;		
				$art->subtitulo = $subtitulo;
				$art->tipo = $tipo;
				$rreiglo[] = $art;
			}		
		}
		return $rreiglo;
	}

	public function getTheArticulo($id, $tipo){
		$q = "SELECT articulos.articulo_id, articulos.titulo, articulos.subtitulo, articulos.tipo, contenido,  mes, dia, year, articulos.colaborador_id, CONCAT(colaboradores.nombre, ' ' ,colaboradores.apellido) as 'colaboradores', articulos.seccion_id, secciones.nombre as 'secciones' FROM articulos JOIN colaboradores ON articulos.colaborador_id = colaboradores.colaborador_id JOIN secciones ON secciones.seccion_id = articulos.seccion_id WHERE status = 0 AND articulo_id = ? AND articulos.tipo = ? ";
		$obj = new stdClass;
		$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('ss', $id, $tipo);
			$stmt->execute();
			$stmt->bind_result($articulo_id, $titulo, $subtitulo, $tipo, $contenido, $mes, $dia, $year, $colaborador_id, $colaborador, $seccion_id, $seccion);
			while($stmt->fetch()){
				$obj->articulo_id = $articulo_id;
				$obj->titulo = $titulo;
				$obj->subtitulo = $subtitulo;
				$obj->tipo = $tipo;
				$obj->contenido = $contenido;
				$obj->mes = $mes;
				$obj->dia = $dia;
				$obj->year = $year;
				$obj->colaborador_id = $colaborador_id;
				$obj->colaborador = $colaborador;
				$obj->seccion_id = $seccion_id;
				$obj->seccion = $seccion;
				$array[] = $obj;
			}
			$stmt->close();
		}

		return $obj;
	}

	public function getVideoByArticuloId($id){
		$q = "SELECT media_id, video_url, articulo_id FROM articulo_media WHERE articulo_id = ?";
		$stmt = $this->dbc->stmt_init();
		$obj = new stdClass;
		if($stmt->prepare($q)) {
 			$stmt->bind_param('i', $id);
 			$stmt->execute();
 			$stmt->bind_result($articulo_media_id, $url, $articulo_id);
 			while($stmt->fetch()){
 				$obj->articulo_media_id = $articulo_media_id;
 				$obj->url = $url;
 				$obj->articulo_id = $articulo_id;
 			}
 			$stmt->close();
 		}
 		return $obj;
	}
}
 ?>