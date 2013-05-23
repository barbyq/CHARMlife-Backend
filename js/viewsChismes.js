var ViewRowChismes = Backbone.View.extend({	
	tagName:"tr",
	render:function  () {
		var contenido = "<td>"+this.model.get("id")+"</td><td>"+this.model.get("titulo")+"</td><td>"+this.model.get("fecha")+"</td><td>"+this.model.get("link")+"</td><td><a href='#chisme/"+this.model.get("id")+"/edit'>Modificar</a></td><td><a id="+this.model.get("id")+" class='.borrar'>Borrar</a></td>";
		this.$el.html(contenido);
		return this;
	}
});

var ViewTablaChismes = Backbone.View.extend({
	tagName:"table",
	className:'colab_edit articulos_main',
	initialize:function() {
	  this.collection.on('add',this.addOne,this);
	  this.collection.on('reset',this.addAll,this);
	},
	addOne:function(chisme) {
		var chismeView = new ViewRowChismes({model: chisme});
		this.$el.append(chismeView.render().el);  
	},
	addAll:function() {
	  this.$el.empty();
	  this.$el.append('<tr><th>Id</th><th>Titulo</th><th>Fecha</th><th>Link</th><th>Modificar</th><th>Borrar</th></tr>');
	  this.collection.forEach(this.addOne,this);
	},
	render:function() {
	  this.addAll();
	  return this;
	}
});