//Models
var Social = Backbone.Model.extend({ });

var Portada = Backbone.Model.extend({ });

var Usuario = Backbone.Model.extend({
	idAttribute:"usuario_id"
});

var Articulo = Backbone.Model.extend({
	idAttribute:"articulo_id"
});
var Colaborador = Backbone.Model.extend({ });
var Area_ = Backbone.Model.extend({ });

var Seccion = Backbone.Model.extend({ });

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

var ColaboradorList = Backbone.Collection.extend({
		model:Colaborador, 
		url: 'controllers/colaboradores_controller.php'
});

var SeccionList = Backbone.Collection.extend({
	initialize: function(){
		this.on('remove', this.hideModel);
	},
	model:Seccion,
	url: 'controllers/secciones_controller.php',
	hideModel: function(model){
		model.trigger('hide');
	}
});

var AreaList = Backbone.Collection.extend({
	initialize: function(){
		this.on('remove', this.hideModel);	
	},
	model: Area_,
	url: 'controllers/areas_controller.php', 
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