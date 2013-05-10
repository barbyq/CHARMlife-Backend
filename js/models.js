
//Models
var Social = Backbone.Model.extend({ });

//Collections
var SocialesList = Backbone.Collection.extend({
	model:Social,
	url: 'controllers/sociales_controller.php'
});

