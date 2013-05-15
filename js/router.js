//= require underscore.js
var articulos = new Articulos();

function addBar(section){
	return '<form class="searchBar" id="searchi"><a href="#' + section +'/add" class="button">Agregar</a></form>';
}

var RouterCharm = Backbone.Router.extend({
	routes:{
		"": "index",
		"sociales":"showSociales",
		"articulos":"showArticulos",
		"articulos/add":"registrararticulo"
		"portadas":"showPortadas",
		"portadas/add":"addPortadas",
		"articulos":"showArticulos",
		"portadas/:id": "showPortada", 
		"portadas/:id/edit":"editPortadas",
		"portadas/:id/delete": "deletePortadas"
	}, index:function  () {
	  $('#main').empty();
	},initialize: function(){
		this.portadasList = new PortadasList();
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
	},
	showArticulos: function () {
		$('#main').empty();
		$('#main').append("<a class='boton-charm natural' href='#articulo/add'>Registra Articulo</a>");
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
	  }, 1000);
	},
	start: function() {
		Backbone.history.start();
	}
});