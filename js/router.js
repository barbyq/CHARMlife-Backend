//= require underscore.js

var RouterCharm = Backbone.Router.extend({
	routes:{
		"": "index",
		"sociales":"showSociales"
	}, 
	initialize: function(){
		
	},
	showSociales: function(){

	},
	start: function() {
		Backbone.history.start();
	}
});