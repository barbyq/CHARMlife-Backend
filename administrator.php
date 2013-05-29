<?php 
	session_start();
	if (isset($_SESSION['user'])) {
		$usuario = $_SESSION['user'];
		$_SESSION['username'] = $usuario->nombre;
		$_SESSION['userid'] = $usuario->usuario_id;		
		$_SESSION['adminlevel'] = $usuario->permisos;
	}else{
		header("Location: index.php");
	}
 ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>CHARMlife Administrador</title>	
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/vendor/bootstrap.css">
	<link rel="stylesheet" href="css/noocupload.css">
	<link rel="stylesheet" type="text/css" href="js/library/chosen.css">
	<link rel="stylesheet" href="css/vendor/jquery.fileupload-ui.css">
	<link rel="stylesheet" href="css/custom-theme/jquery-ui-1.9.2.custom.min.css">
	<script type="text/javascript" src="js/library/jwplayer.flash.swf"></script>
	<script type="text/javascript" src="js/library/jwplayer.html5.js"></script>
	<script type="text/javascript" src="js/library/jwplayer.js"></script>
	<script type="text/javascript" src="js/library/jquery-1.8.3.js"></script>
	<script type="text/javascript" src="http://blueimp.github.com/jQuery-File-Upload/js/vendor/jquery.ui.widget.js"></script>
	<script src="js/library/jquery-ui-1.9.2.custom.min.js"></script>
	<script src="js/library/jquery-ui-1.9.2.barbara.min.js"></script>
	<script type="text/javascript" src="js/library/ajaxfileupload.js"></script>
	<script src="js/library/nicEdit.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/library/handlebars-1.0.rc.1.js"></script>
	<script type="text/javascript" src="js/library/underscore.js"></script>
	<script type="text/javascript" src="js/library/json2.js"></script>
	<script type="text/javascript" src="js/library/backbone.js"></script>
	<script type="text/javascript" src="js/library/chosen.jquery.js"></script>
	<script type="text/javascript" src="js/models.js"></script>
	<script type="text/javascript" src="js/viewsSociales.js"></script>
	<script type="text/javascript" src="js/viewsArticulos.js"></script>
	<script type="text/javascript" src="js/viewsUsuarios.js"></script>
	<script type="text/javascript" src="js/viewsChismes.js"></script>
	<script type="text/javascript" src="js/portadas_views.js"></script>
	<script type="text/javascript" src="js/colaboradores_views.js"></script>
	<script type="text/javascript" src="js/areas_secciones_views.js"></script>
	<script type="text/javascript" src="js/varios_views.js"></script>
	<script type="text/javascript" src="js/router.js"></script>
	<script type="text/javascript" src="js/library/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="js/library/tmpl.min.js"></script>
	<script type="text/javascript" src="js/library/load-image.min.js"></script>
	<script type="text/javascript" src="js/library/canvas-to-blob.min.js"></script>
	<script type="text/javascript" src="js/library/jquery.iframe-transport.js"></script>
	<script type="text/javascript" src="js/library/jquery.fileupload.js"></script>
	<script type="text/javascript" src="js/library/jquery.fileupload-fp.js"></script>
	<script type="text/javascript" src="js/library/jquery.fileupload-ui.js"></script>
	<script type="text/javascript" src="js/library/jquery.ocupload-1.1.2.js"></script>
</head>

<link rel="stylesheet" type="text/css" href="css/styles.css">
<body>
	<script type="text/javascript">
	var UserId = <?php echo $_SESSION['userid']; ?>;
	var CharmRouter = 0;
	$(document).ready(function() {
		CharmRouter = new RouterCharm();
		CharmRouter.start();
		$('#gifi').hide();
        $('#gifi').ajaxStart(function() { $(this).show(); }); 
        $('#gifi').ajaxComplete(function() { $(this).hide(); });
	});
	</script>
	<nav id="mainNav">
		<a href="#" class="toplogo"><img src="img/charm.png" alt="PLAYERS of life Admin"></a>
		<ul>
			<li><a href="#sociales">Sociales</a></li>
			<li><a href="#chismes">¿Que esta pasando?</a></li>
			<li><a href="#portadas">Portadas</a></li>
			<li><a href="#articulos">Articulos</a></li>
			<li><a href="#colaboradores">Colaboradores</a></li>
			<li><a href="#outfit">Outfit</a></li>
			<li><a href="#redes">Amigos en las Redes</a></li>
			<li><a href="#secciones">Secciones</a></li>
			<li><a href="#areas">Areas</a></li>
			<?php if ($_SESSION['adminlevel'] == 1) {
				?>
			<li><a href="#usuarios">Usuarios</a></li>
				<?
			} ?>
			<img id="gifi" src="img/loading.gif">
		</ul>
	</nav>

	<header class="topNav">
	<p>Hello, <span><?php echo $_SESSION['username']; ?></span><br>
		<a href="logout.php">Logout</a>
	</p>
	</header>

	<section id="main">
	</section>


 <!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>Start</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>Cancel</span>
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
            {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}" id="nombrearchivooo">{%=file.name%}</a>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
        {% } %}
        <td class="delete">
            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %} >
                <i class="icon-trash icon-white"></i>
                <span>Delete</span>
            </button>
            <input type="checkbox" name="delete" value="1">
        </td>
    </tr>
{% } %}
</script>

</body>
</html>