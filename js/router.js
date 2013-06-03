//= require underscore.js
var articulos = new Articulos();

function addBar(section){
	return '<form class="searchBar" id="searchi"><a href="#' + section +'/add" class="button">Agregar</a></form>';
}

var usuarios = new Usuarios();

var RouterCharm = Backbone.Router.extend({
	routes:{
		"": "index",
		"sociales":"showSociales",
		"social/add":"addSocial",
		"social/:id/edit":"editsocial",
		"social/:id/data":"editdatasocial",
		"chismes":"chismes",
		"chismes/add":"addchisme",
		"chisme/:id/edit":"editchisme",
		"articulo/:id":"showArticulo",
		"articulos":"showArticulos",
		"articulos/add":"registrararticulo",
		"articulo/:id/edit":"editarArticulo",
		"portadas":"showPortadas",
		"portadas/add":"addPortadas",
		"portadas/:id": "showPortada", 
		"portadas/:id/edit":"editPortadas",
		"portadas/:id/delete": "deletePortadas",
		"usuarios":"usuarios",
		"usuarios/add":"addusuario",
		"usuario/:id/edit":"editusuario",
		"colaboradores":"showColaboradores", 
		"colaboradores/add" : "addColab",
		"colaboradores/:id": "showColaborador",
		"colaboradores/:id/edit": "editColab",
		"secciones":"showSecciones",
		"secciones/add":"addSeccion",
		"secciones/:id/edit":"editSeccion",
		"secciones/:id/delete": "deleteSeccion",
		"areas":"showAreas",
		"areas/add" : "addAreas",
		"areas/:id/edit": "editAreas",
		"areas/:id/delete": "deleteAreas",
		"outfit": "showOutfit",
		"amigosenlasnetworks":"friendsintheredes",
		"banner":"banner"
	}, index:function  () {
	  $('#main').empty();
	},initialize: function(){
		this.portadasList = new PortadasList();
		this.colabList = new ColaboradorList();
		this.areaList = new AreaList();
		this.secList = new SeccionList();
	},
	showSociales: function(){
		$('#main').empty();
		$('#main').append("<a class='boton-charm natural' href='#social/add'>Registra Social</a>");
		var sociales = new Sociales();
		var viewTablaSociales = new ViewTablaSociales({collection: sociales});
		$('#main').append(viewTablaSociales.render().el);
		sociales.fetch();
	},addSocial:function  () {
		var vista = new RegisterSocialView();
		$('#main').html(vista.render().el);
		setTimeout(function  () {
		vista.loader();
		}, 1000);
	},editsocial:function  (edit) {
		var idi = edit;
		$.post("controllers/sociales_controller.php",{receiver:"socialcontinue",idsocial:idi},function  (response) {
			console.log(response);
			var social = new Social(response);
			var editSocial = new EditSocialView({model:social});
			$('#main').html(editSocial.render().el);
			setTimeout(function  () {
				editSocial.loader();
			}, 1000);
		},'json');
	},editdatasocial:function(id) {
		$.post("controllers/sociales_controller",{receiver:"socialcontinue",idsocial:id},function  (response) {
			console.log(response);
			var bd = new Social(response);
			var viewSocialData = new EditDataSocialView({model:bd});
			$('#main').html(viewSocialData.render().el);
			setTimeout(function  () {
				viewSocialData.loader();
			}, 1000);
		},'json');
	},chismes:function  () {
		$('#main').empty();
		$('#main').append("<a class='boton-charm natural' href='#chismes/add'>Registra Chisme</a>");
		var chismes = new Chismes();
		var tablaChismes = new ViewTablaChismes({collection:chismes});
		$('#main').append(tablaChismes.render().el);
		chismes.fetch();
	},addchisme:function  () {
	  $('#main').empty();
	  var registerChisme = new RegisterChismeView();
	  $('#main').html(registerChisme.render().el);
	  setTimeout(function  () {
	    registerChisme.loader();
	  }, 1000);
	},editchisme:function  (id) {
	  $.post("controllers/chismes_controller.php",{receiver:"damechisme",chismeid:id},function  (response) {
	    var chismeedit = new Chisme(response);
	    var chismeEditView = new ChismeEditView({model:chismeedit});
	    $('#main').html(chismeEditView.render().el);
	 	setTimeout(function  () {
	 		chismeEditView.loader();
	 	}, 1000);
	  },'json');
	},
	showPortadas: function(){
		this.portadasList.fetch({async: false});
		var portadasListView = new PortadasListView({collection: this.portadasList});
		portadasListView.render();
		$('#main').empty();
		$('#main').append(addBar('portadas'));
		$('#main').append(portadasListView.el);
	},
	showPortada: function(id){
		if (this.portadasList.length == 0){
			this.portadasList.fetch({async: false});
		}
		var model = this.portadasList.get(id);
		var portadaFullView = new PortadaFullView({model: model});
		portadaFullView.render();
		$('#main').empty();
		$('#main').append(portadaFullView.el);
	}, 
	addPortadas: function(){
		var portadaAddView = new PortadaAddView();
		portadaAddView.render();
		$('#main').empty();
		$('#main').html(portadaAddView.el);
	},
	editPortadas: function(id){
		this.portadasList.fetch({async: false});
		var model = this.portadasList.get(id);
		var portadaEditView = new PortadaEditView({model: model});
		portadaEditView.render();
		$('#main').empty();
		$('#main').html(portadaEditView.el);		
	},
	deletePortadas: function(id){
		var model = this.portadasList.get(id);
		this.portadasList.remove(model);
		var context = this;
		$.post('controllers/portadas_controller.php', {delete: id}, function(data) {
  			context.navigate("portadas", {trigger: true, replace: true});
		});
	},showArticulo:function  (id) {
	  $('#main').empty();
	  $.post("controllers/articulos_controller.php",{receiver:"damearticulo",idarticulo:id},function  (response) {
	    var articulover = new Articulo(response);
	    var vista = new ViewArticulo({model:articulover});
	    $('#main').html(vista.render().el);
	    setTimeout(function  () {
	      vista.cargaTexto();
	      vista.cargaImagenes();
	    }, 1000);
	  },'json');
	},
	showArticulos: function () {
		$('#main').empty();
		$('#main').append("<a class='boton-charm natural' href='#articulos/add'>Registra Articulo</a>");
		$('#main').append("<br/>");
		$('#main').append("<br/>");
		var tablaArticulos = new TablaArticulos({collection:articulos});
		$('#main').append(tablaArticulos.render().el);
		articulos.fetch();
	},registrararticulo:function() {
	  var registro = new RegisterArticulo();
	  $('#main').html(registro.render().el);
	  setTimeout(function  () {
	    nicEditors.allTextAreas();
	    registro.loadColadsandSections();
	    registro.initUploaders();
	    registro.cambiosListener();
	    $('select').chosen();
	  }, 1000);
	},editarArticulo:function  (id) {
	 	$.post("controllers/articulos_controller.php",{receiver:"damearticulo",idarticulo:id},function  (response) {
	 		console.log(response);
	 		var articuloeditable = new Articulo(response);
	 		var editarVista = new EditarArticulo({model:articuloeditable});
	 		$('#main').html(editarVista.render().el);
	 		setTimeout(function  () {
	 		  editarVista.loadStuff();
	 		  editarVista.loadColabs();
	 		}, 1000);
	 	},'json');
	},usuarios:function() {
	  var tablaUsuarios = new ViewTableUsuarios({collection:usuarios});
	  $('#main').empty();
	  $('#main').append("<a class='boton-charm natural' href='#usuarios/add'>Registra Usuario</a>");
	  $('#main').append(tablaUsuarios.render().el);
	  usuarios.fetch();
	},addusuario:function  () {
		var vistaRegistro = new RegisterUserView();
		$('#main').html(vistaRegistro.render().el);
		setTimeout(function  () {
		  $("select").chosen();
		}, 1000);
	},editusuario:function (id) {
	  console.log(id);
	  if (usuarios.length == 0) {
	  	  usuarios.fetch({async:false});
	  }
	  var busqueda = usuarios.find(function  (ble) {
	    return ble.get("usuario_id") == id;
	  })
	  var updateView = new ViewUpdateUser({model:busqueda});
	  $('#main').html(updateView.render().el);
	  setTimeout(function  () {
	    $("select").chosen();
	  }, 1000);
	},showColaboradores: function(){
		console.log("hey");
		$('#main').empty();
		$('#main').html(addBar('colaboradores'));
		this.colabList.fetch({async: false});
		var colabListView = new ColaboradorListView({collection: this.colabList});
		colabListView.render();
		$('#main').append(colabListView.el);
	},
	showColaborador: function(id){
		this.colabList.fetch({async: false});
		var colab = this.colabList.get(id);
		var colabFullView = new ColaboradorFullView({model: colab});
		colabFullView.render();
		$('#main').html(colabFullView.el);	
	},
	addColab: function(){
		colabAddView = new ColaboradorAddView();
		colabAddView.render();
		$('#main').html(colabAddView.el);
		setTimeout(function  () {
			colabAddView.loader();
		}, 1000);
	},
	editColab: function(id){
		if (this.colabList.length == 0){
			this.colabList.fetch({async: false});
		}
		var colab = this.colabList.get(id);
		var colabEditView = new ColaboradorEditView({model: colab});
		colabEditView.render();
		$('#main').html(colabEditView.el);
		setTimeout(function  () {
			colabEditView.loader();
		}, 1000);
	},
	deleteColab: function(id){
		var colab = this.colabList.get(id);
		var context = this;
		$.post('controllers/colaboradores_controller.php', {delete: id}, function(data) {
  			context.navigate("colaboradores", {trigger: true, replace: true});
		});
	},
	showSecciones: function(){
		this.secList.fetch({async: false});
		var seccionListView = new SeccionListView({collection: this.secList});
		seccionListView.render();
		$('#main').empty();
		$('#main').append(addBar('secciones'));
		$('#main').append(seccionListView.el);	

		//console.log("Whatsup");
	},addSeccion: function(){
		var seccAddView = new SeccionAddView();
		seccAddView.render();
		$('#main').html(seccAddView.el);	
	},
	editSeccion: function(id){
		if (this.secList.length == 0){
			this.secList.fetch({async: false});
		}
		var seccion = this.secList.get(id);
		console.log(seccion);
		var seccEditView = new SeccionEditView({model: seccion});
		seccEditView.render();
		$('#main').html(seccEditView.el);
		setTimeout(function  () {
			seccEditView.loader();
		},1000);	
	},
	deleteSeccion: function(id){
		var context = this;
		var seccion = this.secList.get(id);
		this.secList.remove(seccion);
		$.post('controllers/secciones_controller.php', {delete: id}, function(data) {
  			context.navigate("secciones", {trigger: true, replace: true});
		});
	},showAreas: function(){
		this.areaList.fetch({async: false});
		var areaListView = new AreaListView({collection: this.areaList});
		areaListView.render();
		$('#main').empty();
		$('#main').append(addBar('areas'));
		$('#main').append(areaListView.el);
	},
	addAreas: function(){
		var areaAddView = new AreaAddView();
		areaAddView.render();
		$('#main').html(areaAddView.el);	
	},
	editAreas: function(id){
		if (this.areaList.length == 0){
			this.areaList.fetch({async: false});
		}
		var area = this.areaList.get(id);
		var areaEditView = new AreaEditView({model: area});
		areaEditView.render();
		$('#main').html(areaEditView.el);
	},
	deleteAreas: function(id){
		var area = this.areaList.get(id);
		this.areaList.remove(area);
		var context = this;
		$.post('controllers/areas_controller.php', {delete: id}, function(data) {
  			context.navigate("areas", {trigger: true, replace: true});
		});
	},showOutfit: function(){
		$.post("controllers/outfit_controller.php",{receiver:"dameoutfit"},function  (response) {
			console.log(response);
			var outfit = new Outfit(response);
			var outfitView = new OutfitView({model:outfit});
			outfitView.render();
			$('#main').empty();
			$('#main').append(outfitView.el);
			setTimeout(function  () {
				outfitView.loader();
			}, 1000);
		},'json');
	},friendsintheredes:function() {
		$.get("controllers/amigos_controller.php",function (response) {
			var amigo = new Amigo(response);
			var amigosView = new AmigosView({model:amigo});
			$('#main').html(amigosView.render().el);
			setTimeout(function  () {
				amigosView.loader();
			}, 1000);
		},'json');
<<<<<<< HEAD
	},banner:function() {
		$.get("controllers/banner_controller.php",function  (response) {
			console.log(response);
			var banner = new Banner(response);
			var bannerView = new BannerView({model:banner});
			bannerView.render();
			$('#main').empty();
			$('#main').append(bannerView.el);
			setTimeout(function() {
				bannerView.loader();
			}, 1000);
		},'json');
	},
	start: function() {
=======
	},start: function() {
>>>>>>> a76cdaf858595e09b47f973e5ee0b6a6699b0784
		Backbone.history.start();
	}
});