var FilaArticulo = Backbone.View.extend({
	tagName:'tr',
	events:{
		"click .ver":"verarticulo"
	},verarticulo:function(e) {
	  	var elemento = $(e.currentTarget);
		var id = elemento.attr('id');
		CharmRouter.navigate("articulo/"+id, {trigger:true});
	},
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

var ViewArticulo = Backbone.View.extend({
	className:"colab_edit articulos_main",
	cargaTexto:function  () {
		var protegido = this.model.get("contenido");
		var contenido = unescape(protegido);
	  $('#holi').html(contenido);
	},cargaImagenes:function  () {
		var contextotote = this;
	  		$.post('controllers/articulos_controller.php',{receiver:'dameimagenes',articuloid:this.model.get('articulo_id')},function(response) {
			console.log(response);
				if (typeof response['imagenprincipal'] != "undefined") {
					$('#imagenprincipalota').attr('src','Imagenes/'+contextotote.model.get('articulo_id')+'/'+response['imagenprincipal']+"?timestamp=" + new Date().getTime());
				}
				if (typeof response['thumbnail'] != "undefined") {
					$('#tomota').attr('src','Thumbnails/'+contextotote.model.get('articulo_id')+'/'+response['thumbnail']+"?timestamp=" + new Date().getTime());	    
				}	
			
				if (contextotote.model.get('tipo') == 1) {
			    $('#contenidomostrar').html();
				}else if (contextotote.model.get('tipo') == 2) {
					$.post('controllers/articulos_controller.php',{receiver:'damevideo',idvide:contextotote.model.get('articulo_id')},function(response) {
						console.log(response);
						jwplayer('contenidomostrar').setup({
						'flashplayer': 'js/library/jwplayer.flash.swf',
						'id': 'playerID',
					    'width': '480',
					    'height': '360',
					    'file': response,
					    'controlbar': 'bottom'
					  	});
					});
				}
		},'json').fail(function(e) { console.log(e);});
	},
	render:function  () {
		var contexo = this;
		$.get("templates/ViewArticulo.handlebars",function  (response) {
		  var temp = Handlebars.compile(response);
		  var eichtiemel = temp(contexo.model.toJSON());
		  contexo.$el.html(eichtiemel);
		});
	  return this;
	}
});

var RegisterArticulo = Backbone.View.extend({
	id:'registroArticulo',
	className:'colab_edit articulos_main',
	events:{
		"click .registro":"registrar"
	},
	initialize:function  () {
	  	this.iditemporalizador = generaidtexto();
	},registrar:function  () {
	  var contexto = this;
	  var nicE = new nicEditors.findEditor('areaeditor');
	  var cotent = nicE.getContent();
	  var holo = $('#registroArticulo :input').serializeArray();
	  var protegido = escape(cotent);
	  holo.push({name:'contenido',value:protegido});
	  holo.push({name:'registro',value:true});
	  holo.push({name:"userId",value:UserId});
	  holo.push({name:'temporal',value:contexto.iditemporalizador});
	  $.post('controllers/articulos_controller.php',holo,function  (response) {
	  	console.log(response);
	  }).fail(function  (response) {
	    console.log(response);
	  });
	},
	cambiosListener:function  () {
		var contextootravez = this;
		console.log(contextootravez.iditemporalizador);
		$('#yojoyojei').css('display','none');
	  $('#taipin').change(function  () {
	    var tipodearticulo = $(this).val();
	    if (tipodearticulo == '2') {
	    	$('#yojoyojei').css('display','none');
	    	$('#videito').css('display','block');
	    }else{
	    	if (tipodearticulo == '1') {
	    		console.log("smn");
	    		 ActivarVinculacion(contextootravez.iditemporalizador);
               setTimeout(function() {
                  ActivarSubida();
                },2000);
	    		$('#yojoyojei').css('display','block');
	    		$('#videito').css('display','none');
	    	}else{
	    		$('#yojoyojei').css('display','none');
	    		$('#videito').css('display','none');	
	    	}	    	
	    }
	  });
	},
	initUploaders:function  () {
		var contexto = this;
	  	var desubidita = $('#UploadImagen').upload({
			name: 'imagenprincipali',
            action: 'controllers/articulos_controller.php',
            enctype: 'multipart/form-data',
            autoSubmit: true,
            params:{receiver:'imagenprinci',generado:contexto.iditemporalizador},
			onComplete:function() {
				var nombre = desubidita.filename();
				var tipo = nombre.substr(nombre.length - 3);
				$('#imagenprincipali').attr('src','TemporalImagenes/'+contexto.iditemporalizador+'/'+contexto.iditemporalizador+"."+tipo);
			}
		});

		var tom = $('#UploadThumbnail').upload({
			name:'tomneil',
			action:'controllers/articulos_controller.php',
			enctype: 'multipart/form-data',
			autoSubmit: true,
			params:{receiver:'tomtom',generacion:contexto.iditemporalizador},
			onComplete:function() {
				var nomi = tom.filename();
				var coshi = nomi.substr(nomi.length - 3);
				$('#tom').attr('src','TemporalThumbnails/'+contexto.iditemporalizador+'/'+contexto.iditemporalizador+"."+coshi);
			}
		});
	},loadColadsandSections:function() {
		$('#fechagaleriaevento').datepicker();

	  var $colaboradoresDOM = $("<select name='colaboradores' id='colabs'></select>");
	    $.post('controllers/colaboradores_controller.php',{receiver:true},function(response) {
		  	for (var i = 0; i < response.length; i++) {
		  		var nombre = response[i]['nombre'];
		  		var id = response[i]['id'];
		  		$colaboradoresDOM.append('<option value="'+id+'">'+nombre+'</option>');
		  	};
		  	$('#colaboradoreselect').html($colaboradoresDOM);
		  	$('select').chosen();
		  },'json').fail(function(e) { console.log(e); });
	    var $seccionesDOM = $('<select name="secciones" id="seccions"></select>');
	    $.post('controllers/secciones_controller.php',{receiver:true},function(response) {
	    	for (var i = 0; i < response.length; i++) {
		    	var secnombre = response[i]['nombre'];
		    	var secid = response[i]['seccion_id'];
		    	$seccionesDOM.append("<option value='"+secid+"'>"+secnombre+"</option>");
	    	};
	    	$('#seccioneselect').html($seccionesDOM);
	    	$('select').chosen();
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

function ActivarVinculacion(jojojo) {	
   $.post('TemporalGalerias/Recibidor.php',{temporaral:jojojo},function(searmochido) {
  	 	console.log(searmochido);
  	 	console.log("lo mande aca chido");
    }).fail(function(e) {
       console.log(e);
     });
     $.post('TemporalGalerias/Recibidor.php',{temporaral:jojojo},function(searmochido) {
  	 	console.log(searmochido);
  	 	console.log("lo mande aca chido");
    }).fail(function(e) {
       console.log(e);
     });
}

function ActivarSubida () {
  	 $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: 'TemporalGalerias/index.php'
    });

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    if (window.location.hostname === 'blueimp.github.com') {
        // Demo settings:
        $('#fileupload').fileupload('option', {
            url: '//jquery-file-upload.appspot.com/',
            maxFileSize: 5000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            process: [
                {
                    action: 'load',
                    fileTypes: /^image\/(gif|jpeg|png)$/,
                    maxFileSize: 20000000 // 20MB
                },
                {
                    action: 'resize',
                    maxWidth: 1440,
                    maxHeight: 900
                },
                {
                    action: 'save'
                }
            ]
        });
        // Upload server status check for browsers with CORS support:
        if ($.support.cors) {
            $.ajax({
                url: '//jquery-file-upload.appspot.com/',
                type: 'HEAD'
            }).fail(function () {
                $('<span class="alert alert-error"/>')
                    .text('Upload server currently unavailable - ' +
                            new Date())
                    .appendTo('#fileupload');
            });
        }
    } else {
        // Load existing files:
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#fileupload').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload')[0]
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, null, {result: result});
        });
    }
}