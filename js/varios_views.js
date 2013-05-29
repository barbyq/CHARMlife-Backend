var OutfitView = Backbone.View.extend({	
	className:"colab_edit",
	events:{
		"click .natural":"confirmaroutfit"
	},
	initialize:function  () {
		this.iditemporalizador = generaidtexto();
	},confirmaroutfit:function  () {
		$.post("controllers/outfit_controller",{receiver:"confirmaroutfit",generado:this.iditemporalizador},function  (response) {
			console.log(response);
			alert("Guardado Con exito");
			CharmRouter("outfit",{trigger:true});
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

