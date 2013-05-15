//= require underscore.js
var articulos = new Articulos();

var RouterCharm = Backbone.Router.extend({
	routes:{
		"": "index",
		"sociales":"showSociales",
		"articulos":"showArticulos",
		"articulos/add":"registrararticulo"
	}, index:function  () {
	  $('#main').empty();
	},
	initialize: function(){
		
	},
	showSociales: function(){

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
	  }, 1000);
	},
	start: function() {
		Backbone.history.start();
	}
});