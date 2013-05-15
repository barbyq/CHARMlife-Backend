var FilaArticulo = Backbone.View.extend({
	tagName:'tr',
	render:function() {
	var stete = 0;
	if (this.model.get('status') == 0) {
		stete = "Publicado";
	}else if(this.model.get('status') == 1){
		stete = "Borrador";
	}else{
		stete = "En Espera";
	}

	var taip = 0;
	if (this.model.get('tipo') == 0) {
		taip = "Articulo";
	}else if(this.model.get('tipo') == 1){
		taip = "Galeria";
	}else{
		taip = "Video";
	}

	 var eichi = '<td>'+this.model.get('articulo_id')+'</td><td>'+this.model.get('titulo')+'</td><td>'+this.model.get('dia')+'</td><td>'+this.model.get('mes')+'</td><td>'+this.model.get('year')+'</td><td>'+stete+'</td><td>'+taip+'</td><td>'+this.model.get('colaborador_id')+'</td><td>'+this.model.get('usuario_id')+'</td><td>'+this.model.get('seccion_id')+'</td><td><a id="'+this.model.get('articulo_id')+'" class="ver">Ver</a></td><td><a id="'+this.model.get('articulo_id')+'" class="editar">Editar</a></td><td><a id="'+this.model.get('articulo_id')+'" class="borrar">Borrar</a></td>';
	 this.$el.html(eichi);
	 return this;
	}
});

var TablaArticulos = Backbone.View.extend({
	tagName:"table",
	className:'colab_edit articulos_main',
	initialize:function() {
	  this.collection.on('add',this.addOne,this);
	  this.collection.on('reset',this.addAll,this);
	},
	addOne:function(article) {
		var articleView = new FilaArticulo({model: article});
		this.$el.append(articleView.render().el);  
	},
	addAll:function() {
	  this.$el.empty();
	  this.$el.append('<tr><<th>Id</th><th>Titulo</th><th>Dia</th><th>Mes</th><th>Año</th><th>Status</th><th>Tipo</th><th>Colaborador</th><th>Usuario</th><th>Seccion</th><th>Ver</th><th>Modificar</th><th>Borrar</th>/tr>');
	  this.collection.forEach(this.addOne,this);
	},
	render:function() {
	  this.addAll();
	  return this;
	}
});

var RegisterArticulo = Backbone.View.extend({
	id:'registroArticulo',
	tagName:'form',
	className:'colab_edit articulos_main',
	initialize:function  () {
	  	this.iditemporalizador = generaidtexto();
	},cambiosListener:function  () {
	  $('#taipin').change(function  () {
	    var tipodearticulo = $(this).val();
	    if (tipodearticulo == '2') {
	    	$('#videito').css('display','block');
	    }else{
	    	$('#videito').css('display','none');
	    }
	  });
	},
	initUploaders:function  () {
		var contexto = this;
	  	var desubidita = $('#kokokokoko').upload({
			name: 'imagenprincipali',
            action: '/proyectoDigital/controllers/articulocontroller.php',
            enctype: 'multipart/form-data',
            autoSubmit: true,
            params:{receiver:'imagenprinci',generado:contexto.iditemporalizador},
			onComplete:function() {
				var nombre = desubidita.filename();
				var tipo = nombre.substr(nombre.length - 3);
				$('#imagenprincipali').attr('src','/proyectoDigital/controllers/Tempeprincipalis/'+contexto.iditemporalizador+'/'+contexto.iditemporalizador+"."+tipo);
			}
		});

		var tom = $('#tomneil').upload({
			name:'tomneil',
			action:'/proyectoDigital/controllers/articulocontroller.php',
			enctype: 'multipart/form-data',
			autoSubmit: true,
			params:{receiver:'tomtom',generacion:contexto.iditemporalizador},
			onComplete:function() {
				var nomi = tom.filename();
				var coshi = nomi.substr(nomi.length - 3);
				$('#tom').attr('src','/proyectoDigital/controllers/Temptomneils/'+contexto.iditemporalizador+'/'+contexto.iditemporalizador+"."+coshi);
			}
		});
	},loadColadsandSections:function() {
	  var $colaboradoresDOM = $("<select id='colabs'></select>");

	    $.post('controllers/colaboradores_controller.php',{receiver:true},function(response) {
		  	for (var i = 0; i < response.length; i++) {
		  		var nombre = response[i]['nombre'];
		  		var id = response[i]['colaborador_id'];
		  		console.log(nombre);
		  		console.log(id);
		  		$colaboradoresDOM.append('<option value="'+id+'">'+nombre+'</option>');
		  	};
		  	$('#colaboradoreselect').html($colaboradoresDOM);
		  	$('select').chosen();
		  },'json');

	    $.post('controllers/secciones_controller.php',function  (response) {
	    	console.log(response);
	    },'json');
	},
	render:function() {
		var contexto = this;
		$.get('views/RegistrarArticulo.handlebars',function  (response) {
		  contexto.$el.html(response);
		});
	  return this;
	}
});

function generaidtexto () {
	var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 30; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}