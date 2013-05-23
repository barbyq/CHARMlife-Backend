var ViewRowChismes = Backbone.View.extend({	
	tagName:"tr",
	events:{
		"click .borrar":"borrar"
	},borrar:function(e) {
		var contexto = this;
		var elemento = $(e.currentTarget);
		var id = elemento.attr('id');
		if (confirm("Seguro que quieres borrarlo?")) {
			$.post("controllers/chismes_controller.php",{receiver:"borrar",idchisme:this.model.get("id")},function  (response) {
				contexto.$el.remove();
			});
		};
	},
	render:function  () {
		var contenido = "<td>"+this.model.get("id")+"</td><td>"+this.model.get("titulo")+"</td><td>"+this.model.get("fecha")+"</td><td>"+this.model.get("link")+"</td><td><a href='#chisme/"+this.model.get("id")+"/edit'>Modificar</a></td><td><a id="+this.model.get("id")+" class='borrar'>Borrar</a></td>";
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

var RegisterChismeView =Backbone.View.extend({
	id:"registrochisme",
	className:"colab_chisme",
	events:{
		"click .registrarchisme":"registrarchisme"
	},
	initialize:function  () {
	  this.iditemporalizador = generaidtexto();
	},registrarchisme:function  () {
	  var valores = $('#registrochisme :input').serializeArray();
	  valores.push({name:"temporal",value:this.iditemporalizador});
	  valores.push({name:"receiver",value:"registro"});
	  $.post("controllers/chismes_controller.php",valores,function  (response) {
	    alert("Guardado con exito!");
	    CharmRouter.navigate("chismes",{trigger:true});
	  });
	},
	loader:function() {	  
		var contexto = this;
		$('#fechachisme').datepicker();
	  	var desubidita = $('#dominicdococo').upload({
			name: 'imagenchisme',
            action: 'controllers/chismes_controller.php',
            enctype: 'multipart/form-data',
            autoSubmit: true,
            params:{receiver:'imagenchisme',generado:contexto.iditemporalizador},
			onComplete:function() {
				var nombre = desubidita.filename();
				var tipo = nombre.substr(nombre.length - 3);
				$('#imagenchisme').attr('src','TemporalChismes/'+contexto.iditemporalizador+'/'+contexto.iditemporalizador+"."+tipo);
			}
		});
	},
	render:function  () {
		var contexto = this;
		$.get("templates/RegisterChisme.handlebars",function  (response) {
		  contexto.$el.html(response);
		});
	  return this;
	}
});

var ChismeEditView = Backbone.View.extend({
	id:"updatechisme",
	className:"colab_chisme",
	events:{
		"click .updatechisme":"updatechisme"
	},updatechisme:function  () {
		var valores = $('#updatechisme :input').serializeArray();
		valores.push({name:"receiver",value:"update"});
		valores.push({name:"chismeid",value:this.model.get("id")});
		$.post("controllers/chismes_controller.php",valores,function  (response) {
			alert("Modificado con exito!");
			CharmRouter.navigate("chismes",{trigger:true});
		});
		console.log(valores);
	},
	loader:function  () {
		var contexto = this;
		$('#fechachismedit').datepicker();
		if (this.model.get("foto") != 0) {
			$('#imagenchismeedit').attr("src",this.model.get("foto")+"?timestamp=" + new Date().getTime());
		};
	  	var desubidita = $('#dominicdococoedit').upload({
			name: 'imagenchisme',
            action: 'controllers/chismes_controller.php',
            enctype: 'multipart/form-data',
            autoSubmit: true,
            params:{receiver:'updateimagen',idchisme:contexto.model.get("id")},
			onComplete:function() {
				var nombre = desubidita.filename();
				var tipo = nombre.substr(nombre.length - 3);
				$('#imagenchismeedit').attr('src','Chismes/'+contexto.model.get("id")+'/'+contexto.model.get("id")+"."+tipo+"?timestamp=" + new Date().getTime());
			}
		});
	},
	render:function  () {
		var contexto = this;
		$.get("templates/UpdateChisme.handlebars",function  (response) {
			var con = Handlebars.compile(response);
			var eichtiemel = con(contexto.model.toJSON());
		  	contexto.$el.html(eichtiemel);
		});
	  return this;
	}
});