<?php 
/**
 * Dao de Tags
 */
 class tagsDAO
 {
 	private $dbc;

	function __construct($dbc)
 	{
 		$this->dbc = $dbc;
 	}

 	public function dameTags()
 	{
 		$busqueda = "SELECT * FROM tags_main order by tag_id asc";
 		$st = $this->dbc->stmt_init();
 		$arr = array();
 		$quer = $this->dbc->query($busqueda);
 		while ($mono = $quer->fetch_object()) {
 			$arr[] = $mono;
 		}
 		return $arr;
 	}

 	public function registerTag($obj)	
 	{
 		$ins = "INSERT into tags_main(nombre) values(?)";
 		$st = $this->dbc->stmt_init();
 		if ($st->prepare($ins)) {
 			$st->bind_param("s", $obj->nombre);
 			$st->execute();
 		}
 	}

 	public function updateTag($obj)
 	{
		$ins = "UPDATE tags_main set nombre = ? where tag_id = ?";
 		$st = $this->dbc->stmt_init();
 		if ($st->prepare($ins)) {
 			$st->bind_param("si", $obj->nombre,$obj->update);
 			$st->execute();
 		}
 	}

 	public function deleteTag($id)
 	{
 		$ins = "DELETE from tags_main where tag_id = ?";
 		$st = $this->dbc->stmt_init();
 		if ($st->prepare($ins)) {
 			$st->bind_param("i", $id);
 			$st->execute();
 		}
 	}

 	public function givemetag($id)
 	{
		$bs = "SELECT * from tags_main where tag_id = ?";
		$si = $this->dbc->stmt_init();
		$bli = new stdClass;
		if ($si->prepare($bs)) {
			$si->bind_param("i", $id);
			$si->execute();
			$si->bind_result($id,$nombre);
			while ($si->fetch()) {
				$bli->tag_id = $id;
				$bli->nombre = $nombre;
			}
		}
		return $bli;
 	}
 } ?>