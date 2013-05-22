/*Colaboradores*/
var ColaboradorView = Backbone.View.extend({
	initialize: function(){
		this.model.on('change', this.render, this);
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
		//console.log(this);
		return this;
	},
	tagName : 'tr',
});

var ColaboradorFullView = Backbone.View.extend({
	initialize: function(){
		this.model.on('change', this.render, this);
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
	initialize: function(){
		this.model.on('change', this.render, this);
	},
	render: function(){
		var attributes = this.model.toJSON();
		var template; 
		var context = this;


		var seccionList = new SeccionList();
		seccionList.fetch({async: false});
		var seccion = seccionList.toJSON();

		console.log("ColaboradorEditView");
		$.get('templates/colabEdit.handlebars', function(data){
			Handlebars.registerHelper('ifeq', function (a, b, options) {
      			if (a == b) { return options.fn(this); }
    		});
			template = Handlebars.compile(data);
			context.$el.html(template(attributes));

			var arraySecciones = [];
			$.each(attributes.secciones, function(key, value){
				arraySecciones.push(value.seccion_id);
			});

			$.each(seccion, function(key, value){
   				$('#seccionSelect').append('<option value="'+value.id+'">'+value.nombre+'</option>');
			});
			console.log(arraySecciones);
			$('#seccionSelect').val(arraySecciones);
			$("select").chosen(); 

			var imgs = new Array();

			$("input.uploadImg").upload({
				name: 'file',
		        action: 'processImg.php',
		        enctype: 'multipart/form-data',
		        params: {id: attributes.id},
		        autoSubmit: true,
		        onSubmit: function() {
		        },
		        onComplete: function(data) {
		        	if (data != 'error' && data != 'Invalid File'){
		        		d = new Date();
						$("img.uploadImg").attr("src", data+"?"+d.getTime());
						//$('.info').text("Actualizado");
						imgs.push(data);
						$('.imgs_array').val(imgs);
						$('.error').text("");
		        	}else{
		        		$('.error').text("Archivo Invalido");
		        	}
		        },
		        onSelect: function() {}
			});
		});
		return context;

	}
});

var ColaboradorAddView = Backbone.View.extend({
	render: function(){
		var context = this;
		
		$.get('templates/colabEdit.handlebars', function(data){
			var seccionList = new SeccionList();
			seccionList.fetch({async: false});
			var attributes = seccionList.toJSON();

			Handlebars.registerHelper('ifeq', function (a, b, options) {
      			if (a == b) { return options.fn(this); }
    		});
			template = Handlebars.compile(data);
			context.$el.html(template({seccion: attributes}));
			var tempData = '';
			console.log('temp here:' + tempData);
			$("select").chosen(); 
			$("input.uploadImg").upload({
				name: 'file',
		        action: 'processImg.php',
		        enctype: 'multipart/form-data',
		        params: {action:'add', temp:tempData},
		        autoSubmit: true,
		        onSubmit: function() {
		        	
		        },
		        onComplete: function(data) {
		        	console.log('temp before: ' + tempData );
		        	if (data != 'error'){
						tempData = data.substring(26,data.length);
						console.log('temp after: ' + tempData);		        		
		        		d = new Date();
		        		this.params({temp:tempData});
						$("img.uploadImg").attr("src", data+"?"+d.getTime());
						$("input.colaboradores_imagen").val(tempData);
						/*$('.info').text("Actualizado");*/
		        	}
		        },
		        onSelect: function() {
		        	
		        }
			});

		});
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
		var tableTop = '<tr><th>Nombre</th><th>Giro</th><th>Tipo</th><th>Medio</th><th>Secciones</th><th>Plaza</th><th></th></tr>';
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

