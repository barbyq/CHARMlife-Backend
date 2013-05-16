<!DOCTYPE html>
<html lang="es">
<head>
	<title>CHARMlife Administrador</title>	
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/vendor/bootstrap.css">
	<link rel="stylesheet" href="css/noocupload.css">
	<link rel="stylesheet" type="text/css" href="js/library/chosen.css">

	<script type="text/javascript" src="js/library/jquery-1.8.3.js"></script>
	<script src="js/library/nicEdit.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/library/handlebars-1.0.rc.1.js"></script>
	<script type="text/javascript" src="js/library/underscore.js"></script>
	<script type="text/javascript" src="js/library/json2.js"></script>
	<script type="text/javascript" src="js/library/backbone.js"></script>
	<script type="text/javascript" src="js/library/chosen.jquery.js"></script>
	<script type="text/javascript" src="js/models.js"></script>
	<script type="text/javascript" src="js/viewsArticulos.js"></script>
	<script type="text/javascript" src="js/portadas_views.js"></script>
	<script type="text/javascript" src="js/router.js"></script>
	<script type="text/javascript" src="js/library/jquery.ocupload-1.1.2.js"></script>
</head>

<link rel="stylesheet" type="text/css" href="css/styles.css">
<body>
	<script type="text/javascript">
	var CharmRouter = 0;
	$(document).ready(function() {
		CharmRouter = new RouterCharm();
		CharmRouter.start();
	});
	</script>
	<nav id="mainNav">
		<a href="#" class="toplogo"><img src="img/charm.png" alt="PLAYERS of life Admin"></a>
		<ul>
			<li><a href="#">Sociales</a></li>
			<li><a href="#chismes">¿Que esta pasando?</a></li>
			<li><a href="#portadas">Portadas</a></li>
			<li><a href="#articulos">Articulos</a></li>
			<li><a href="#colaboradores">Colaboradores</a></li>
			<li><a href="#">Usuarios</a></li>
			<li><a href="#Config">Configuraciones</a></li>
		</ul>
	</nav>

	<header class="topNav">
	<p>Hello, <span><?php echo $_SESSION['username']; ?></span><br>
		<a href="logout.php">Logout</a>
	</p>
	</header>

	<section id="main">
	</section>
</body>
</html>