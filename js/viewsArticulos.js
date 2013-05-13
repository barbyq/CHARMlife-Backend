var FilaArticulo = Backbone.View.extend({
	tagName:'tr',
	render:function() {
	 var eichi = '<td>'+this.model.get('articulo_id')+'</td><td>'+this.model.get('titulo')+'</td><td>'+this.model.get('dia')+'</td><td>'+this.model.get('mes')+'</td><td>'+this.model.get('year')+'</td><td>'+stete+'</td><td>'+taip+'</td><td>'+this.model.get('colaborador_id')+'</td><td>'+this.model.get('usuario_id')+'</td><td>'+this.model.get('seccion_id')+'</td><td><a id="'+this.model.get('articulo_id')+'" class="ver">Ver</a></td><td><a id="'+this.model.get('articulo_id')+'" class="editar">Editar</a></td><td><a id="'+this.model.get('articulo_id')+'" class="borrar">Borrar</a></td>';
	 this.$el.html(eichi);
	 return this;
	}
});

var TablaArticulos = Backbone.View.extend({
	tagName:"table",
	initialize:function  () {
	  this.collection.on('add',this.addOne,this);
	  this.collection.on('reset',this.addAll,this);
	},
	addOne:function  (article) {
		var articleView = FilaArticulo({model: article});
		this.$el.append(articleView.render().el);  
	},
	addAll:function  () {
	  this.$el.empty();
	  this.$el.append('<tr><<th>Id</th><th>Titulo</th><th>Dia</th><th>Mes</th><th>Año</th><th>Status</th><th>Tipo</th><th>Colaborador</th><th>Usuario</th><th>Seccion</th><th>Ver</th><th>Modificar</th><th>Borrar</th>/tr>');
	  this.collection.forEach(this.addOne.this);
	},
	render:function() {
	  this.addAll();
	  return this;
	}
});