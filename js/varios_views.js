var OutfitView = Backbone.View.extend({	
	className:"colab_edit",
	events:{
		"click .natural":"confirmaroutfit"
	},
	initialize:function  () {
		this.iditemporalizador = generaidtexto();
	},confirmaroutfit:function  () {
		$.post("controllers/outfit_controller",{receiver:"confirmaroutfit",generado:this.iditemporalizador},function  (response) {
			alert("Guardado Con exito");
			CharmRouter.navigate("outfit",{trigger:true});
		});	
	},
	loader:function  () {
		var contexto = this;
			var subiroutfit = $('#UploadImagen').upload({
				name: 'temporaloutfit',
		           action: 'controllers/outfit_controller.php',
		           enctype: 'multipart/form-data',
		           autoSubmit: true,
		           params:{receiver:'subiroutfit',generado:contexto.iditemporalizador},
				onComplete:function() {
					var nombre = subiroutfit.filename();
					var tipo = nombre.substr(nombre.length - 3);
					$('.uploadImg').attr('src','TemporalOutfit/'+contexto.iditemporalizador+'/'+contexto.iditemporalizador+"."+tipo);
				}
			});
	},render: function(){
		var context = this;
		$.get('templates/outfitView.handlebars', function(data){
			var	template = Handlebars.compile(data);
			var con = template(context.model.toJSON());
			context.$el.html(con);
		});
		return this;
	}
});

var AmigosView = Backbone.View.extend({
	id:"amigos",
	className:"colab_chisme amigos_main",
	events:{
		"click .ramigos":"ramigos"
	},
	initialize:function  () {
	  this.primera = generaidtexto();
	  this.segunda = generaidtexto();
	  this.tercera = generaidtexto();
	  this.cuarta = generaidtexto();
	  this.quinta = generaidtexto();
	  this.sexta = generaidtexto();
	},ramigos:function  () {
	  $.post("controllers/amigos_controller.php",{receiver:"registrar",primera:this.primera,segunda:this.segunda,tercera:this.tercera,cuarta:this.cuarta,quinta:this.quinta,sexta:this.sexta},function  (response) {
	  	console.log(response);
		alert("Guardado con exito!");
  	  });
	},
	loader:function() {	  
		var contexto = this;
			  	var primera = $('#uploadprimera').upload({
					name: 'primera',
		            action: 'controllers/amigos_controller.php',
		            enctype: 'multipart/form-data',
		            autoSubmit: true,
		            params:{receiver:'primera',generado:contexto.primera},
					onComplete:function() {
						var nombre = primera.filename();
						var tipo = nombre.substr(nombre.length - 3);
					$('#primera').attr('src','TemporalAmigos/'+contexto.primera+'/'+contexto.primera+"."+tipo);
					}
				});

			  	var segunda = $('#uploadsegunda').upload({
					name: 'segunda',
		            action: 'controllers/amigos_controller.php',
		            enctype: 'multipart/form-data',
		            autoSubmit: true,
		            params:{receiver:'segunda',generado:contexto.segunda},
					onComplete:function() {
						var nombre = segunda.filename();
						var tipo = nombre.substr(nombre.length - 3);
					$('#segunda').attr('src','TemporalAmigos/'+contexto.segunda+'/'+contexto.segunda+"."+tipo);
					}
				});
			  	var tercera = $('#uploadtercera').upload({
					name: 'tercera',
		            action: 'controllers/amigos_controller.php',
		            enctype: 'multipart/form-data',
		            autoSubmit: true,
		            params:{receiver:'tercera',generado:contexto.tercera},
					onComplete:function() {
						var nombre = tercera.filename();
						var tipo = nombre.substr(nombre.length - 3);
					$('#tercera').attr('src','TemporalAmigos/'+contexto.tercera+'/'+contexto.tercera+"."+tipo);
					}
				});

			  	var cuarta = $('#uploadcuarta').upload({
					name: 'cuarta',
		            action: 'controllers/amigos_controller.php',
		            enctype: 'multipart/form-data',
		            autoSubmit: true,
		            params:{receiver:'cuarta',generado:contexto.cuarta},
					onComplete:function() {
						var nombre = cuarta.filename();
						var tipo = nombre.substr(nombre.length - 3);
					$('#cuarta').attr('src','TemporalAmigos/'+contexto.cuarta+'/'+contexto.cuarta+"."+tipo);
					}
				});

			  	var quinta = $('#uploadquinta').upload({
					name: 'quinta',
		            action: 'controllers/amigos_controller.php',
		            enctype: 'multipart/form-data',
		            autoSubmit: true,
		            params:{receiver:'quinta',generado:contexto.quinta},
					onComplete:function() {
						var nombre = quinta.filename();
						var tipo = nombre.substr(nombre.length - 3);
					$('#quinta').attr('src','TemporalAmigos/'+contexto.quinta+'/'+contexto.quinta+"."+tipo);
					}
				});
			  	var sexta = $('#uploadsexta').upload({
					name: 'sexta',
		            action: 'controllers/amigos_controller.php',
		            enctype: 'multipart/form-data',
		            autoSubmit: true,
		            params:{receiver:'sexta',generado:contexto.sexta},
					onComplete:function() {
						var nombre = sexta.filename();
						var tipo = nombre.substr(nombre.length - 3);
					$('#sexta').attr('src','TemporalAmigos/'+contexto.sexta+'/'+contexto.sexta+"."+tipo);
					}
				});
	},render:function  () {
		var contexto = this;
		$.get("templates/Amigos.handlebars",function  (response) {
			var cnen = Handlebars.compile(response);
			var yem = cnen(contexto.model.toJSON());
			contexto.$el.html(yem);
		});
	  return this;
	}
});

var BannerView = Backbone.View.extend({
	id:"bannerregistro",
	className:"colab_chisme",
	events:{
		"click .rbannerregistro":"rbannerregistro"
	},
	initialize:function  () {
	  this.iditemporalizador = generaidtexto();
	},rbannerregistro:function  () {
	  $.post("controllers/banner_controller.php",{receiver:"confirmarbanner",generado:this.iditemporalizador},function  (response) {
	    // alert("Guardado con exito!");
	    // CharmRouter.navigate("banner",{trigger:true});
	  });
	},
	loader:function() {	  
		var contexto = this;
	  	var BannerSubir = $('#UploadImagen').upload({
			name: 'banner',
            action: 'controllers/banner_controller.php',
            enctype: 'multipart/form-data',
            autoSubmit: true,
            params:{receiver:'subirbanner',generado:contexto.iditemporalizador},
			onComplete:function() {
				var nombre = BannerSubir.filename();
				var tipo = nombre.substr(nombre.length - 3);
			$('.uploadImg').attr('src','TemporalBanner/'+contexto.iditemporalizador+'/'+contexto.iditemporalizador+"."+tipo);
			}
		});
	},
	render:function  () {
		var contexto = this;
		$.get("templates/Banner.handlebars",function  (response) {
			var	template = Handlebars.compile(response);
			var con = template(contexto.model.toJSON());
			contexto.$el.html(con)
		});
	  return this;
	}
});