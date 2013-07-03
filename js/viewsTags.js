var ViewRowTag = Backbone.View.extend({	
	tagName:"tr",
	events:{
		"click .borrar":"borrar"
	},borrar:function(e) {
		var contexto = this;
		var elemento = $(e.currentTarget);
		var id = elemento.attr('id');
		if (confirm("Seguro que quieres borrarlo?")) {
			$.post("controllers/tags_controller.php",{borrar:this.model.get("tag_id")},function  (response) {
				contexto.$el.remove();
			});
		};
	},
	render:function  () {
		var contenido = "<td>"+this.model.get("tag_id")+"</td><td>"+this.model.get("nombre")+"</td><td><a href='#tags/"+this.model.get("tag_id")+"/edit'>Modificar</a></td><td><a id="+this.model.get("tag_id")+" class='borrar'>Borrar</a></td>";
		this.$el.html(contenido);
		return this;
	}
});

var ViewTablaTags = Backbone.View.extend({
	tagName:"table",
	className:'colab_edit articulos_main',
	initialize:function() {
	  this.collection.on('add',this.addOne,this);
	  this.collection.on('reset',this.addAll,this);
	},
	addOne:function(tag) {
		var TagRowView = new ViewRowTag({model: tag});
		this.$el.append(TagRowView.render().el);  
	},
	addAll:function() {
	  this.$el.empty();
	  this.$el.append('<tr><th>Id</th><th>Tag</th><th>Modificar</th><th>Borrar</th></tr>');
	  this.collection.forEach(this.addOne,this);
	},
	render:function() {
	  this.addAll();
	  return this;
	}
});

var RegisterTagView = Backbone.View.extend({
	id:"registrotag",
	className:"colab_edit",
	events:{
		"click .registrartag":"registrartag"
	},
	initialize:function  () {
	},registrartag:function  () {
	  var valores = $('#registrotag :input').serializeArray();
	  valores.push({name:"registro",value:true});
	  $.post("controllers/tags_controller.php",valores,function  (response) {
	    alert("Guardado con exito!");
	    CharmRouter.navigate("tags",{trigger:true});
	  });
	},
	loader:function() {	  
		var contexto = this;
	},
	render:function  () {
		var contexto = this;
		$.get("templates/RegisterTag.handlebars",function  (response) {
		  contexto.$el.html(response);
		});
	  return this;
	}
});

var EditTagView = Backbone.View.extend({
	id:"registroedittag",
	className:"colab_edit",
	events:{
		"click .registraredittag":"registraredittag"
	},
	initialize:function  () {
	  this.iditemporalizador = generaidtexto();
	},registraredittag:function  () {
	  var valores = $('#registroedittag :input').serializeArray();
	  valores.push({name:"update",value:this.model.get("tag_id")});
	  $.post("controllers/tags_controller.php",valores,function  (response) {
	    alert("Guardado con exito!");
	    CharmRouter.navigate("tags",{trigger:true});
	  });
	},
	loader:function() {	  
		var contexto = this;
	},
	render:function  () {
		var contexto = this;
		$.get("templates/EditTag.handlebars",function  (response) {
		   var contenido = Handlebars.compile(response);
		   var eichitiemel = contenido(contexto.model.toJSON());
		   contexto.$el.html(eichitiemel);
		});
	  return this;
	}
});