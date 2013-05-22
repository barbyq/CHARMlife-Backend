//Models
var Social = Backbone.Model.extend({ });

var Portada = Backbone.Model.extend({ });

var Usuario = Backbone.Model.extend({
	idAttribute:"usuario_id"
});

var Articulo = Backbone.Model.extend({
	idAttribute:"articulo_id"
});

//Collections
var SocialesList = Backbone.Collection.extend({
	model:Social,
	url: 'controllers/sociales_controller.php'
});

var PortadasList = Backbone.Collection.extend({
	initialize: function(){
		this.on('remove', this.hideModel);	
	},
	model: Portada,
	url: 'controllers/portadas_controller.php', 
	hideModel: function(model){
		model.trigger('hide');
	}
});

var Articulos = Backbone.Collection.extend({
	model:Articulo,
	url:'controllers/articulos_controller.php'
});

var Usuarios = Backbone.Collection.extend({
	model: Usuario,
	url:"controllers/usuarios_controller.php"
});