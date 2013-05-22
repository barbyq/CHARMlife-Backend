<?php 
	
	/**
	* 
	*/
	class usuariosDAO
	{
		private $dbc;

		function __construct($con)
		{
			$this->dbc = $con;	
		}

		public function getUsuarios()
		{
			$arreglo = array();
			$busqueda = "SELECT * FROM usuarios";
			$q = $this->dbc->query($busqueda);
			while ($holi = $q->fetch_object()) {
				$arreglo[] = $holi;
			}
			return $arreglo;
		}

	public function registerUser($user)
	{
		$comida = md5($user->password);

		$insercion = "INSERT INTO usuarios(nombre,username,password,permisos) values(?,?,?,?)";
		$statutin = $this->dbc->stmt_init();
		if ($statutin->prepare($insercion)) {
			$statutin->bind_param('sssi', $user->nombre,$user->username,$comida,$user->levelup);
			$statutin->execute();
		}
		$statutin->close();
	}
	
	public function eraseUser($oki)
	{
		$borrado = "DELETE FROM usuarios where usuario_id = ?";
		$stmt = $this->dbc->stmt_init();
		if ($stmt->prepare($borrado)) {
			$stmt->bind_param('i', $oki);
			$stmt->execute();	
		}
		$stmt->close();
	}

	public function updateUser($user)
	{
		$comidota = md5($user->password);
		print_r($comidota);
		$updata = "UPDATE usuarios set nombre = ?, username = ?, password = ?, permisos = ? where usuario_id = ?";
		$estatuto = $this->dbc->stmt_init();
		if ($estatuto->prepare($updata)) {
			$estatuto->bind_param('sssii',$user->nombre,$user->username,$comidota,$user->levelup,$user->id);
			$estatuto->execute();
		}
	}


	}

 ?>