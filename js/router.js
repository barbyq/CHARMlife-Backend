//= require underscore.js
var articulos = new Articulos();


var RouterCharm = Backbone.Router.extend({
	routes:{
		"": "index",
		"sociales":"showSociales",
		"portadas":"showPortadas",
		"articulos":"showArticulos"
	}, 
	initialize: function(){
		
	},
	showSociales: function(){

	},
	showPortadas: function(){
		
	},
	showArticulos: function () {
		$('#main').empty();
		$('#main').append("<a class='boton-charm natural' href='#articulo/add'>Registra Articulo</a>");
		$('#main').append("<br/>");
		$('#main').append("<br/>");
		var tablaArticulos = new TablaArticulos({collection:articulos});
		$('#main').append(tablaArticulos.render().el);
		articulos.fetch();
	},
	start: function() {
		Backbone.history.start();
	}
});