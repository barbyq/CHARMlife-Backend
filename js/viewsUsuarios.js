var ViewRowUsuario = Backbone.View.extend({
	tagName:"tr",
	events:{
		"click .borrar":"borrar"
	},borrar:function  (e) {
	  	var contexto = this;
	  	var elemento = $(e.currentTarget);
		var id = elemento.attr('id');
		if (confirm("Seguro que quieres borrar?")) {
			$.post("controllers/usuarios_controller.php",{borrar:id},function  (response) {
			  contexto.$el.remove();
			  console.warn(response);
			});
		};
	},
	render:function  () {
		var tipo = "Editor";
		if (this.model.get("permisos") == 1) {
			tipo = "Administrador";
		};
		var holo = "<td>"+this.model.get("usuario_id")+"</td><td>"+this.model.get("username")+"</td><td>"+this.model.get("nombre")+"<td>"+tipo+"</td><td><a href='#usuario/"+this.model.get("usuario_id")+"/edit'>Editar</a></td><td><a id='"+this.model.get("usuario_id")+"' class='borrar'>Borrar</a></td>";
	  	this.$el.html(holo);
	  	return this;
	}
});

var ViewTableUsuarios = Backbone.View.extend({	
	tagName:"table",
	className:"colab_edit",
	initialize:function() {
	  this.collection.on('add',this.addOne,this);
	  this.collection.on('reset',this.addAll,this);
	},
	addOne:function(usuario) {
		var filaUser= new ViewRowUsuario({model: usuario});
		this.$el.append(filaUser.render().el);  
	},
	addAll:function() {
	  this.$el.empty();
	  this.$el.append('<tr><<th>Id</th><th>Username</th><th>Nombre</th><th>Tipo</th><th>Modificar</th><th>Borrar</th>/tr>');
	  this.collection.forEach(this.addOne,this);
	},
	render:function  () {
	  this.addAll();
	  return this;
	}
});

var RegisterUserView = Backbone.View.extend({
	className:"colab_edit",
	id:"RegistroUser",
	events:{
		"click .registro":"registrar"
	},
	registrar:function() {
		var datos = $('#RegistroUser :input').serializeArray();
		datos.push({name:"registro",value:true});
		$.post("controllers/usuarios_controller.php",datos,function  (response) {
			console.log(response);
			alert("Guardado con exito!");
			CharmRouter.navigate("usuarios", {trigger:true});
		});
	},
	render:function() {
		var contexto = this;
		$.get("templates/RegisterUser.handlebars",function  (response) {
			contexto.$el.html(response);
		});
		return this;
	}
});

var ViewUpdateUser = Backbone.View.extend({
	id:"update",
	className:"colab_edit",
	events:{
		"click .updeitro":"update"
	},update:function  () {
	  var datos = $('#update :input').serializeArray();
	  console.log(datos);
	  datos.push({name:"update",value:true});
	  datos.push({name:"usuario_id",value:this.model.get("usuario_id")});
	  $.post("controllers/usuarios_controller.php",datos,function  (response) {
	    console.log(response);
	    alert("Actualizado con exito!");
	    CharmRouter.navigate("usuarios",{trigger:true});
	  });
	},
	render:function() {
		Handlebars.registerHelper('ifeq', function (a, b, options) {
      		if (a == b) { return options.fn(this); }
    	});
		var contexto = this;
		$.get("templates/UpdateUser.handlebars",function(response) {
			var tem = Handlebars.compile(response);
			var eichtiemel = tem(contexto.model.toJSON());
			contexto.$el.html(eichtiemel);
		});
	  return this;
	}
});