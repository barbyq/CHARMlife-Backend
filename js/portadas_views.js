var arrayMes = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
/*PORTADAS */
var PortadaView = Backbone.View.extend({
	initialize: function(){
		this.model.on('change', this.render, this);
	},
	render: function(){
		var context = this;
		var attributes = this.model.toJSON();
		$.get('templates/portadaView.handlebars', function(data){
			template = Handlebars.compile(data);
			context.$el.html(template(attributes));
		});
		//console.log(this);
		return this;
	},
	tagName : 'tr',
});

var PortadaFullView = Backbone.View.extend({
	render: function(){
		var context = this;
		var attributes = this.model.toJSON();
		$.get('templates/portadaFullView.handlebars', function(data){
			template = Handlebars.compile(data);
			context.$el.html(template(attributes));
		});
		return this;
	},
	tagName : 'div',
	className: 'colab_edit'
});

var PortadaAddView = Backbone.View.extend({
	render: function(){
		var context = this;
		$.get('templates/portadaEdit.handlebars', function(data){
			template = Handlebars.compile(data);
			context.$el.html(template);

			var year = new Date().getFullYear();
			for (j = 2012; j <= year; j++){
				$('#ano_select').append('<option>' + j +'</option>');	
			}

			for(x = 0; x < 12; x++){
				$('#mes_select').append('<option value="'+ (x+1) +'">' + arrayMes[x] +'</option>');		
			}

			$("select").chosen();
			var tempBanner = "";
			var tempMobBanner = "";

			var temp = new Date().getTime();
			var arrayBanner = new Array();
			var arrayBannerMob = new Array();
			console.log(temp);

			$('input.uploadPortada').upload({
			        name: 'file',
			        action: 'upload/processImgPortadas.php',
			        enctype: 'multipart/form-data',
			        params: {action: 'add', temp: temp, mob: 'false'},
			        autoSubmit: true,
			        onSubmit: function() {
			        	
			        },
			        onComplete: function(data) {
			        	if (data != 'error' && data != 'Invalid File'){
			        		console.log(data);
			        		var tempData = data.substring(data.lastIndexOf("temp/"),data.length);
			        		console.log(tempData);
			        		$("img.uploadPortada").attr("src", data);
			        		arrayBanner.push(tempData);
			        		$('.imgs_array').val(arrayBanner);
			        	}else{
			        		console.log("Archivo Invalido");
			        	}
			        },
			        onSelect: function() {}
			});


			$('input.uploadPortadasThumb').upload({
			        name: 'file',
			        action: 'upload/processImgPortadas.php',
			        enctype: 'multipart/form-data',
			        params: {action: 'add', temp: temp, mob: 'true'},
			        autoSubmit: true,
			        onSubmit: function() {},
			        onComplete: function(data) {
			        	if (data != 'error' && data != 'Invalid file'){
			        		console.log(data);
			        		var tempData = data.substring(data.lastIndexOf("temp/"),data.length);
			        		console.log(tempData);
			        		$("img.uploadPortadasThumb").attr("src", data);
			        		arrayBannerMob.push(tempData);
			        		$('.imgsmob_array').val(arrayBannerMob);
			        	}else{
			        		console.log("Archivo Invalido");
			        	}
			        },
			        onSelect: function() {}
			});

		});
		return this;
	}
});	

var PortadaEditView = Backbone.View.extend({
	render: function(){
		var context = this;
		var attributes = this.model.toJSON();
		$.get('templates/portadaEdit.handlebars', function(data){
			template = Handlebars.compile(data);
			context.$el.html(template(attributes));

			var year = new Date().getFullYear();
			for (j = 2006; j <= year; j++){
				$('#ano_select').append('<option>' + j +'</option>');	
			}

			for(x = 0; x < 12; x++){
				$('#mes_select').append('<option value="'+ (x+1) +'">' + arrayMes[x] +'</option>');		
			}

			$('#mes_select').val(attributes.mes);
			$('#ano_select').val(attributes.year);	

			$("select").chosen();
			var tempBanner = "";
			var tempMobBanner = "";

			var temp = new Date().getTime();
			var arrayBanner = new Array();
			var arrayBannerMob = new Array();
			arrayBanner.push(attributes.img);
			arrayBannerMob.push(attributes.img_thumb);

			$('input.uploadPortada').upload({
			        name: 'file',
			        action: 'upload/processImgPortadas.php',
			        enctype: 'multipart/form-data',
			        params: {action: 'edit', temp: temp, mob: 'false'},
			        autoSubmit: true,
			        onSubmit: function() {
			        	
			        },
			        onComplete: function(data) {
			        	if (data != 'error' && data != 'Invalid File'){
			        		console.log(data);
			        		var tempData = data.substring(data.lastIndexOf("temp/"),data.length);
			        		console.log(tempData);
			        		$("img.uploadPortada").attr("src", data);
			        		arrayBanner.push(tempData);
			        		$('.imgs_array').val(arrayBanner);
			        	}else{
			        		console.log("Archivo Invalido");
			        	}
			        },
			        onSelect: function() {}
			});


			$('input.uploadPortadasThumb').upload({
			        name: 'file',
			        action: 'upload/processImgPortadas.php',
			        enctype: 'multipart/form-data',
			        params: {action: 'edit', temp: temp, mob: 'true'},
			        autoSubmit: true,
			        onSubmit: function() {},
			        onComplete: function(data) {
			        	if (data != 'error' && data != 'Invalid file'){
			        		console.log(data);
			        		var tempData = data.substring(data.lastIndexOf("temp/"),data.length);
			        		console.log(tempData);
			        		$("img.uploadPortadasThumb").attr("src", data);
			        		arrayBannerMob.push(tempData);
			        		$('.imgsmob_array').val(arrayBannerMob);
			        	}else{
			        		console.log("Archivo Invalido");
			        	}
			        },
			        onSelect: function() {}
			});

		});
		return this;
	}
});	

var PortadasListView = Backbone.View.extend({
	initialize: function(){
		this.collection.on('add', this.addOne, this);
		this.collection.on('reset', this.addAll, this);
	},
	render: function(){
		this.addAll()
    	return this;
	}, 
	addAll: function(){
		this.$el.empty();
		var tableTop = '<tr><th>ID</th><th>Plaza</th><th>Mes</th><th>Año</th><th></th><th></th><th></th></tr>';
		this.$el.html(tableTop);
		this.collection.forEach(this.addOne, this);
	},
	addOne: function(model){
		console.log("here?");
		var portadaView = new PortadaView({model: model});
		portadaView.render();
		this.$el.append(portadaView.el);
	},
	tagName: 'table',
	className: 'colab_edit colab_main '
});