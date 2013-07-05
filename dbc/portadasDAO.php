<?php
class portadasDAO{
	private $dbc;
	public $first_ed_month = 3;
	public $first_ed_year = 2012;

	public function  __construct($connection)
	{
		$this->dbc = $connection;
	}

	public function getEdicion($mes, $year){
		$string1 = $this->first_ed_year . '-' . $this->first_ed_month . '-1';
		$string2 = $year . '-'. $mes . '-1';
		$date1 = new DateTime($string1);
		$date2 = new DateTime($string2);
		$interval = $date1->diff($date2);
		$years = $interval->y;
		$total = $years*12;
		$months = $interval->m;
		$total = $total+$months;
		return $total+1;
	}

	public function getPortadas(){
		$q = "SELECT portadas_id as 'id', mes, year, img, img_thumb, edicion FROM portadas ORDER BY plaza_id, year, mes";
		$array = array();
		$r = $this->dbc-> query($q);
		while ($obj = $r->fetch_object()) {
			$obj->mes_ = getMes($obj->mes);
			$array[] = $obj;
		}
		return $array;
	}

	public function getPortada($id){
		$q = "SELECT portadas_id as 'id', mes, year, img, img_thumb, edicion FROM portadas WHERE portada_id = ?";
		$stmt = $this->dbc->stmt_init();
		$obj = new stdClass;
		if($stmt->prepare($q)) {
 			$stmt->bind_param('i', $id);
 			$stmt->execute();
 			$stmt->bind_result($portada_id, $mes, $year, $img, $img_thumb, $edicion);
 			while($stmt->fetch()){
 				$obj->portada_id = $portada_id;
 				$obj->mes = $mes;
 				$obj->year = $year;
 				$obj->img = $img;
 				$obj->img_thumb = $img_thumb;
 				$obj->edicion = $edicion;
 			}
 			$stmt->close();
 		}
 		return $obj;
	}

	public function insertPortada($obj){
		$edicion = $this->getEdicion($obj->mes, $obj->year);
		$q = "INSERT INTO portadas (mes, year, img, img_thumb,edicion) VALUES (?, ?, ?, ?, ?)";
		$stmt = $this->dbc->stmt_init();
 		if($stmt->prepare($q)) {
 			$stmt->bind_param('ssssi', $obj->mes, $obj->year, $obj->img, $obj->img_thumb, $edicion);
 			$stmt->execute();
 		}
 		$id = $this->dbc->insert_id;
		return $id;
	}

	public function updatePortada($obj){
		$q = "UPDATE portadas SET plaza_id = ?, mes = ?, year = ?, img = ?, img_thumb = ? WHERE portadas_id = ?";
		$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('ssssss', $obj->plaza_id, $obj->mes, $obj->year, $obj->img, $obj->img_thumb, $obj->id);
			$stmt->execute();
		}
		$stmt->close();
		return $obj;
	}

	public function deletePortada($id){
		$q = "DELETE FROM portadas WHERE portadas_id = ?";
		$stmt = $this->dbc->stmt_init();
		if($stmt->prepare($q)) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
		}
		$stmt->close();
	}

	public function PortadasByYear($year)
	{
		$busqueda = "SELECT portadas_id,mes,year,img,img_thumb,edicion from portadas where year = ? order by mes DESC";
		$esta = $this->dbc->stmt_init();
		$arreglo = array();
		if ($esta->prepare($busqueda)) {
			$esta->bind_param("i",$year);
			$esta->execute();
			$esta->bind_result($id,$mes,$year,$img,$img_thumb,$edicion);
			while ($esta->fetch()) {
				$portada = new stdClass;
				$portada->id = $id;
				$portada->mes = $mes;
				$portada->year = $year;
				$portada->img = $img;
				$portada->img_thumb = $img_thumb;
				$portada->edicion = $edicion;
				$portada->meso = getMes($mes);
				$arreglo[] = $portada;
			}
		}
		return $arreglo;
	}

	public function getUltimaPortada()
	{
		$blis = "SELECT portadas_id,mes,year,img,img_thumb,edicion from portadas order by portadas_id desc limit 1;";
		$ing = $this->dbc->query($blis);
		$returnboy = 0;
		while ($b = $ing->fetch_object()) {
			$returnboy = $b;
		}
		return $returnboy;
	}

/*
	public function showyears($plaza)
	{
		$arreglo = array();
		$esttuto = "SELECT distinct year from portadas where plaza_id = ? order by year desc";
		$estat = $this->dbc->stmt_init();
		if ($estat->prepare($esttuto)) {
			$estat->bind_param("i",$plaza);
			$estat->execute();
			$estat->bind_result($year);
			while ($estat->fetch()) {
				$yeari = new stdClass;
				$yeari->year = $year;
				$arreglo[] = $yeari;
			}
		}
		return $arreglo;
	}

	public function obteneryears($plaza)
	{
		$arreglo = array();
		$esttuto = "SELECT distinct year from portadas where plaza_id = ? order by year asc";
		$estat = $this->dbc->stmt_init();
		if ($estat->prepare($esttuto)) {
			$estat->bind_param("i",$plaza);
			$estat->execute();
			$estat->bind_result($year);
			while ($estat->fetch()) {
				$arreglo[] = $year;
			}
		}
		$estat->close();
		return $arreglo;
	}

	public function obtenermeses($year,$plaza)
	{
		$arreglo = array();
		$esttuto = "SELECT mes from portadas where year=? and plaza_id=? order by mes asc;";
		$estat = $this->dbc->stmt_init();
		if ($estat->prepare($esttuto)) {
			$estat->bind_param("ii",$year,$plaza);
			$estat->execute();
			$estat->bind_result($mes);
			while ($estat->fetch()) {
				$arreglo[] = $mes;
			}
		}
		$estat->close();
		return $arreglo;
	}

	public function dameporYearyPlaza($year,$plaza)
	{
		$arreglofiltrado = array();
		$estatuto = "SELECT portadas_id,plaza_id,mes,year,img,img_thumb,edicion from portadas where year = ? and plaza_id = ? order by mes asc";
		$estat = $this->dbc->stmt_init();
		if ($estat->prepare($estatuto)) {
			$estat->bind_param("ii",$year,$plaza);
			$estat->execute();
			$estat->bind_result($id,$plaza,$mes,$year,$img,$img_thumb,$edicion);
			while ($estat->fetch()) {
				$holapo = new stdClass;
				$holapo->portadas_id = $id;
				$holapo->plaza_id = $plaza;
				$holapo->mes = $mes;
				$holapo->year = $year;
				$holapo->img = $img;
				$holapo->imgthumb = $img_thumb;
				$holapo->edicion = $edicion;
				$arreglofiltrado[] = $holapo; 
			}
		}
		return $arreglofiltrado;	
	}

	public function getPortadaMesYearPlaza($plaza_id){
		$q = "SELECT portadas_id, plaza_id, mes, year, img, img_thumb,edicion FROM portadas WHERE year = YEAR(CURDATE()) AND mes = MONTH(CURDATE()) AND plaza_id = ?";
		$stmt = $this->dbc->stmt_init();
		$obj = new stdClass;
		if($stmt->prepare($q)) {
 			$stmt->bind_param('i', $plaza_id);
 			$stmt->execute();
 			$stmt->bind_result($portadas_id,  $plaza_id, $mes, $year, $img, $img_thumb,$edicion);
 			while($stmt->fetch()){
 				$obj->portadas_id = $portadas_id;
 				$obj->mes = $mes;
 				$obj->year = $year;
 				$obj->img = $img;
 				$obj->img_thumb = $img_thumb;
 				$obj->plaza_id = $plaza_id;
 				$obj->edicion = $edicion;
 				$obj->plaza = getPlaza($obj->plaza_id);
 			}
 			$stmt->close();
 		}
 		return $obj;
	}

	public function execute()
	{
		$plazas = array(1,2,3,4,5);
		$dias = array('1','2','3','4','5','6','7','8','9','10','11','12');
		foreach ($plazas as $plaza) {
			$arregloyears = $this->obteneryears($plaza);
			$contador = 1;
			$mesanterior = null;
			foreach ($arregloyears as $year) {
				$meses = $this->obtenermeses($year,$plaza);
					for ($i=0; $i < count($meses); $i++) { 
						if (in_array($meses[$i],$dias)) {
						 	if (isset($meses[$i - 1])) {
								$diferencia = ((int)$meses[$i] - (int)$meses[$i-1]);
								if ($diferencia == 1) {
								 	$this->insertarcontador($meses[$i],$year,$plaza,$contador);
								 	$contador++;
								}else{
									$contador++;
									$this->insertarcontador($meses[$i],$year,$plaza,$contador);
									$contador++;
								}
						 	}else{
						 		if (isset($mesanterior)) {
						 			$diferencia = ((int)$meses[$i] - (int)$mesanterior);
						 			if ($diferencia === -11) {
						 				$this->insertarcontador($meses[$i],$year,$plaza,$contador);
								  		$contador++;
						 			}else{
								  		$contador++;
								  		$this->insertarcontador($meses[$i],$year,$plaza,$contador);
								  		$contador++;
						 			}
						 		}else{
							  		$this->insertarcontador($meses[$i],$year,$plaza,$contador);
									$contador++;
						 		}
						 	}
						}
					}
				$indexlast = count($meses) - 1;
				$mesanterior = $meses[$indexlast];
			}
		}
		print_r("Done...");
	}

	public function insertarcontador($mes,$year,$plaza,$contador)
	{
		$bus = "UPDATE portadas set edicion = ? where plaza_id = ? and mes = ? and year = ?;";
		$estatutote = $this->dbc->stmt_init();
		if ($estatutote->prepare($bus)) {
			$estatutote->bind_param("iiii",$contador,$plaza,$mes,$year);
			$estatutote->execute();
		}
		$estatutote->close();
	}*/

}
?>