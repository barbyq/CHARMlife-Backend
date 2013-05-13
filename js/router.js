//= require underscore.js
var articulos = new Articulos();


var RouterCharm = Backbone.Router.extend({
	routes:{
		"": "index",
		"sociales":"showSociales"
		"articulos":"showArticulos"
	}, 
	initialize: function(){
		
	},
	showSociales: function(){

	},
	showArticulos: function () {
		articulos.fetch();
	},
	start: function() {
		Backbone.history.start();
	}
});