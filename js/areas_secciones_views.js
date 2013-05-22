/*Areas*/
var AreaView = Backbone.View.extend({
	initialize: function(){
		this.model.on('hide', this.remove, this);
	},
	render: function(){
		var context = this;
		var attributes = this.model.toJSON();
		$.get('/proyectoDigital/templates/areaView.handlebars', function(data){
			template = Handlebars.compile(data);
			context.$el.html(template(attributes));
		});
		return this;
	},
	tagName: 'tr'
});

var AreaAddView = Backbone.View.extend({
	render: function(){
		console.log("AreaAddView");
		var context = this;
		$.get('/proyectoDigital/templates/areaEdit.handlebars', function(data){
			/*Handlebars.registerHelper('ifeq', function (a, b, options) {
      			if (a == b) { return options.fn(this); }
    		});*/
			template = Handlebars.compile(data);
			context.$el.html(template);
		});
		return this;
	}
});

var AreaEditView = Backbone.View.extend({
	render: function(){
		console.log("AreaEditView");
		var context = this;
		var attributes = this.model.toJSON();
		$.get('/proyectoDigital/templates/areaEdit.handlebars', function(data){
			/*Handlebars.registerHelper('ifeq', function (a, b, options) {
      			if (a == b) { return options.fn(this); }
    		});*/
			template = Handlebars.compile(data);
			context.$el.html(template(attributes));
		});
		return this;
	}
});

var AreaListView = Backbone.View.extend({
	initialize: function(){
		this.collection.on("add", this.addOne, this);
		this.collection.on("reset", this.addAll, this);
	},
	render: function(){
		this.addAll();
		return this;
	},
	addOne: function(model){
		var areaView = new AreaView({model: model});
		areaView.render();
		this.$el.append(areaView.el);
	},
	addAll: function(){
		this.$el.empty();
		var tableTop = '<tr><th>ID</th><th>Nombre</th><th></th><th></th></tr>';	
		this.$el.html(tableTop);
		this.collection.forEach(this.addOne, this);
	},
	tagName: 'table', 
	className: 'colab_edit' 
});

/*Secciones*/
var SeccionView = Backbone.View.extend({
	initialize: function(){
		this.model.on('hide', this.remove, this);
	},
	render: function(){
		var context = this;
		var attributes = this.model.toJSON();
		$.get('/proyectoDigital/templates/seccionView.handlebars', function(data){
			template = Handlebars.compile(data);
			context.$el.html(template(attributes));
		});
		return this;
	},
	tagName: 'tr'
});

var SeccionAddView = Backbone.View.extend({
	render: function(){
		console.log("SeccionAddView");
		var context = this;
		var areaList = new AreaList();
		areaList.fetch({async: false});

		$.get('/proyectoDigital/templates/seccionEdit.handlebars', function(data){
			template = Handlebars.compile(data);
			context.$el.html(template);

			areaList.forEach(function(area){
  				$('#areasSelect').append('<option value="'+area.get('id')+'">'+area.get('nombre')+'</option>');
			});
			$("select").chosen(); 
		});
		return this;
	}
});

var SeccionEditView = Backbone.View.extend({
	render: function(){
		console.log("SeccionEditView");
		var context = this;
		var attributes = this.model.toJSON();

		var areaList = new AreaList();
		areaList.fetch({async: false});


		$.get('/proyectoDigital/templates/seccionEdit.handlebars', function(data){
			template = Handlebars.compile(data);
			context.$el.html(template(attributes));

			areaList.forEach(function(area){
  				$('#areasSelect').append('<option value="'+area.get('id')+'">'+area.get('nombre')+'</option>');
			});
			$('#areasSelect').val(attributes.area_id);
			$("select").chosen(); 
			//$('#areasSelect').val();
		});
		return this;
	}
});

var SeccionListView = Backbone.View.extend({
	initialize: function(){
		this.collection.on("add", this.addOne, this);
		this.collection.on("reset", this.addAll, this);
	},
	render: function(){
		this.addAll();
		return this;
	},
	addOne: function(model){
		var seccionView = new SeccionView({model: model});
		seccionView.render();
		this.$el.append(seccionView.el);
	},
	addAll: function(){
		this.$el.empty();
		var tableTop = '<tr><th>ID</th><th>Nombre</th><th>Area</th><th></th><th></th></tr>';	
		this.$el.html(tableTop);
		this.collection.forEach(this.addOne, this);
	},
	tagName: 'table', 
	className: 'colab_edit' 
});


