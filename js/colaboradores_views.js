/*Colaboradores*/
var ColaboradorView = Backbone.View.extend({
	initialize: function(){
		this.model.on('change', this.render, this);
	},events:{
		"click .borrar":"borrar"
	},borrar:function  (e) {
		var contexto = this;
	  	var elemento = $(e.currentTarget);
		var id = elemento.attr('id');
		if (confirm("seguro que quieres borrarlo?")) {
			$.post("controllers/colaboradores_controller.php",{receiver:"borrar",idcolab:id},function  (response) {
				contexto.$el.remove();
			});
		};
	},
	render: function(){
		var context = this;
		var attributes = this.model.toJSON();
		$.get('templates/colabView.handlebars', function(data){
			Handlebars.registerHelper('ifeq', function (a, b, options) {
      			if (a == b) { return options.fn(this); }
    		});
			template = Handlebars.compile(data);
			context.$el.html(template(attributes));
		});
		console.log("render ColaboradorView");
		return this;
	},
	tagName : 'tr',
});

var ColaboradorFullView = Backbone.View.extend({
	initialize: function(){
		this.model.on('change', this.render, this);
	},events:{
		"click .borrar":"borrar"
	},borrar:function(e) {
		var elemento = $(e.currentTarget);
		var id = elemento.attr('id');
		if (confirm("seguro que quieres borrarlo?")) {
			$.post("controllers/colaboradores_controller.php",{receiver:"borrar",idcolab:id},function  (response) {
				alert("borrado con exito!");
				CharmRouter.navigate("colaboradores",{trigger:true});
			});
		};
	},
	render: function(){
		var attributes = this.model.toJSON();
		var template; 
		var context = this;
		console.log("ColaboradorFullView");
		$.get('templates/colabFull.handlebars', function(data){
			Handlebars.registerHelper('ifeq', function (a, b, options) {
      			if (a == b) { return options.fn(this); }
    		});
			template = Handlebars.compile(data);
			context.$el.html(template(attributes));
		});
		return this;
	},
	tagName : 'div',
	className: 'colab_edit'
});

var ColaboradorEditView = Backbone.View.extend({
	id:"editorcolab",
	className:"colab_edit",
	events:{
		"click .reditorcolab":"reditorcolab"
	},
	initialize:function  () {
	  this.iditemporalizador = generaidtexto();
	},reditorcolab:function  () {
	  var valores = $('#editorcolab :input').serializeArray();
	  valores.push({name:"temporal",value:this.iditemporalizador});
	  valores.push({name:"receiver",value:"editar"});
	  valores.push({name:"id",value:this.model.get("id")});
	  console.log(valores);
	  $.post("controllers/colaboradores_controller.php",valores,function  (response) {
	    console.log(response);
	     alert("Guardado con exito!");
	     CharmRouter.navigate("colaboradores",{trigger:true});
	  });
	},
	loader:function() {	  
		var contexto = this;
		$('select').chosen();

	  	var editupload = $('input.uploadImg').upload({
			name: 'imagen',
            action: 'controllers/colaboradores_controller.php',
            enctype: 'multipart/form-data',
            autoSubmit: true,
            params:{receiver:'editupload',generado:contexto.model.get("id")},
			onComplete:function() {
				var nombre = editupload.filename();
				var tipo = nombre.substr(nombre.length - 3);
			$('img.uploadImg').attr('src','Profiles/'+contexto.model.get("id")+'/'+contexto.model.get("id")+"."+tipo+"?timestamp=" + new Date().getTime());
			}
		});

	},
	render:function  () {
		var contexto = this;
		$.get("templates/colabEdit.handlebars",function  (response) {
			var seccionList = new SeccionList();
			seccionList.fetch({async: false});
			var seccion = seccionList.toJSON();

			Handlebars.registerHelper('ifeq', function (a, b, options) {
     
      			if (a == b) { return options.fn(this); }
    		});
		  var coni = Handlebars.compile(response);
		  var eichtiemel = coni(contexto.model.toJSON());
		  contexto.$el.html(eichtiemel);

			var arraySecciones = [];
			$.each(contexto.model.toJSON().secciones, function(key, value){
				arraySecciones.push(value.seccion_id);
			});

			$.each(seccion, function(key, value){
   				$('#seccionSelect').append('<option value="'+value.id+'">'+value.nombre+'</option>');
			});
			console.log(arraySecciones);
			$('#seccionSelect').val(arraySecciones);
			$("select").chosen(); 

		});
	  return this;
	}
});

var ColaboradorAddView = Backbone.View.extend({
	id:"agregarcolaborador",
	className:"colab_edit",
	events:{
		"click .guardarcolab":"raddcolaborador"
	},
	initialize:function  () {
	  this.iditemporalizador = generaidtexto();
	},raddcolaborador:function  () {
	  var valores = $('#agregarcolaborador :input').serializeArray();
	  valores.push({name:"temporal",value:this.iditemporalizador});
	  valores.push({name:"receiver",value:"registro"});
	  $.post("controllers/colaboradores_controller.php",valores,function  (response) {
	  console.log(response);
	     alert("Guardado con exito!");
	     CharmRouter.navigate("colaboradores",{trigger:true});
	  });
	},
	loader:function() {
		$('select').chosen();
		var contexto = this;
		  	var profile = $('input.uploadImg').upload({
				name: 'profilepic',
	            action: 'controllers/colaboradores_controller.php',
	            enctype: 'multipart/form-data',
	            autoSubmit: true,
	            params:{receiver:'subirprofile',generado:contexto.iditemporalizador},
				onComplete:function() {
					var nombre = profile.filename();
					var tipo = nombre.substr(nombre.length - 3);
					$('img.uploadImg').attr('src','TemporalProfiles/'+contexto.iditemporalizador+'/'+contexto.iditemporalizador+"."+tipo);
				}
			});
	},
	render:function  () {
		var context = this;
		$.get("templates/colabAdd.handlebars",function  (response) {
			var seccionList = new SeccionList();
			seccionList.fetch({async: false});
			var attributes = seccionList.toJSON();

			Handlebars.registerHelper('ifeq', function (a, b, options) {
      			if (a == b) { return options.fn(this); }
    		});
			template = Handlebars.compile(response);
			context.$el.html(template({seccion: attributes}));		});
	  return this;
	}
});

var ColaboradorListView = Backbone.View.extend({
	initialize: function(){
		this.collection.on('add', this.addOne, this);
		this.collection.on('reset', this.addAll, this);
	},
	render: function(){
		console.log("Render ColaboradorListView");
		this.addAll()
    	return this;
	}, 
	addAll: function(){
		console.log("Add All after reset");
		this.$el.empty();
		var tableTop = '<tr><th>Nombre</th><th>Giro</th><th>Tipo</th><th>Medio</th><th>Secciones</th><th>Ver</th><th>Editar</th><th>Borrar</th></tr>';
		this.$el.html(tableTop);
		this.collection.forEach(this.addOne, this);
	},
	addOne: function(colab){
		console.log("here?");
		var colabView = new ColaboradorView({model: colab});
		colabView.render();
		console.log("Render ColabView");
		this.$el.append(colabView.el);
	},
	tagName: 'table',
	className: 'colab_edit colab_main'
});

/*Secciones*/
var SeccionListView = Backbone.View.extend({


});

