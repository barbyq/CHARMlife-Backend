//Models
var Social = Backbone.Model.extend({ });

var Articulo = Backbone.Model.extend({
	idAttribute:"articulo_id"
});

//Collections
var SocialesList = Backbone.Collection.extend({
	model:Social,
	url: 'controllers/sociales_controller.php'
});

var Articulos = Backbone.Collection.extend({
	model:Articulo,
	url:'controllers/articulos_controller.php'
});