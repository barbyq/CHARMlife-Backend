//= require underscore.js
var articulos = new Articulos();


var RouterCharm = Backbone.Router.extend({
	routes:{
		"": "index",
		"sociales":"showSociales",
		"articulos":"showArticulos"
	}, 
	initialize: function(){
		
	},
	showSociales: function(){

	},
	showArticulos: function () {
		var tablaArticulos = new TablaArticulos({collection:articulos});
		$('#main').html(tablaArticulos.render().el);
		articulos.fetch();
	},
	start: function() {
		Backbone.history.start();
	}
});