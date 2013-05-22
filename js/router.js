//= require underscore.js
var articulos = new Articulos();

function addBar(section){
	return '<form class="searchBar" id="searchi"><a href="#' + section +'/add" class="button">Agregar</a></form>';
}

var RouterCharm = Backbone.Router.extend({
	routes:{
		"": "index",
		"sociales":"showSociales",
		"articulo/:id":"showArticulo",
		"articulos":"showArticulos",
		"articulos/add":"registrararticulo",
		"articulo/:id/edit":"editarArticulo",
		"portadas":"showPortadas",
		"portadas/add":"addPortadas",
		"portadas/:id": "showPortada", 
		"portadas/:id/edit":"editPortadas",
		"portadas/:id/delete": "deletePortadas",
		"colaboradores":"showColaboradores", 
		"colaboradores/add" : "addColab",
		"colaboradores/:id": "showColaborador",
		"colaboradores/:id/edit": "editColab",
		"colaboradores/:id/delete": "deleteColab"
	}, index:function  () {
	  $('#main').empty();
	},initialize: function(){
		this.portadasList = new PortadasList();
		this.colabList = new ColaboradorList();
	},
	showSociales: function(){

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
	},
	editColab: function(id){
		if (this.colabList.length == 0){
			this.colabList.fetch({async: false});
		}
		var colab = this.colabList.get(id);
		var colabEditView = new ColaboradorEditView({model: colab});
		colabEditView.render();
		$('#main').html(colabEditView.el);
	},
	deleteColab: function(id){
		var colab = this.colabList.get(id);
		var context = this;
		$.post('controllers/colaboradores_controller.php', {delete: id}, function(data) {
  			context.navigate("colaboradores", {trigger: true, replace: true});
		});
	},
	start: function() {
		Backbone.history.start();
	}
});