var FilaArticulo = Backbone.View.extend({
	tagName:'tr',
	events:{
		"click .ver":"verarticulo",
		"click .editar":"editarArticulo",
		"click .borrar":"borrarArticulo"
	},verarticulo:function(e) {
	  	var elemento = $(e.currentTarget);
		var id = elemento.attr('id');
		CharmRouter.navigate("articulo/"+id, {trigger:true});
	},editarArticulo:function(e) {
	   	var elemento = $(e.currentTarget);
		var id = elemento.attr('id');
		CharmRouter.navigate("articulo/"+id+"/edit", {trigger:true});
	},borrarArticulo:function  (e) {
		var contexto = this;
	   	var elemento = $(e.currentTarget);
		var id = elemento.attr('id');
		console.log(id);
		if (confirm("¿Seguro que lo quieres borrar?")) {
			$.post('controllers/articulos_controller.php',{receiver:"borrar",idarticulo:id},function  (response) {
		 	 console.log(response);
		 	 contexto.$el.remove();
			}).fail(function  (e) {
			  console.log(e);
			});
		};
	},render:function() {
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
	}else if(this.model.get("tipo") == 2){
		taip = "Video";
	}else{
		taip = "Tematica"
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
	  	alert("Guardado con exito");
	  	CharmRouter.navigate("articulos", {trigger:true});
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

	  	var mascharm = $('#yemn3upi').upload({
			name: 'mascharmfile',
		           action: 'controllers/articulos_controller.php',
		           enctype: 'multipart/form-data',
		           autoSubmit: true,
		           params:{receiver:'mascharm',generado:contexto.iditemporalizador},
			onComplete:function() {
				var nombre = mascharm.filename();
				var tipo = nombre.substr(nombre.length - 3);
				$('#mascharm').attr('src','TemporalMasCharm/'+contexto.iditemporalizador+'/'+contexto.iditemporalizador+"."+tipo);
			}
		});
	},loadColadsandSections:function() {
	    $('#fechagaleriaevento').datepicker();
	    $.get("controllers/tags_controller.php",function(response) {
	    	console.log(response);
	    	for (var i = 0; i < response.length; i++) {	
	    		$('#tagSelect').append("<option value='"+response[i]['tag_id']+"'>"+response[i]['nombre']+"</option>");
	    	}
	    },'json');
	    setTimeout(function() {
		  var $colaboradoresDOM = $("<select name='colaboradores' id='colabs'></select>");
		    $.post('controllers/colaboradores_controller.php',{receiver:true},function(response) {
			  	for (var i = 0; i < response.length; i++) {
			  		var nombre = response[i]['nombrec'];
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
			    	var secid = response[i]['id'];
			    	$seccionesDOM.append("<option value='"+secid+"'>"+secnombre+"</option>");
		    	};
		    	$('#seccioneselect').html($seccionesDOM);
		    	$('select').chosen();
		    },'json');

	    },500);
	},
	render:function() {
		var contexto = this;
		$.get('views/RegistrarArticulo.handlebars',function  (response) {
		  contexto.$el.html(response);
		});
	  return this;
	}
});

var EditarArticulo = Backbone.View.extend({	
	id:"todaedicion",
	className:"colab_edit articulos_main",
	events:{
		"click .actualizar":"update"
	},update:function() {
	  var contexto = this;
	  var nic = new nicEditors.findEditor("areaupdate");	
	  var contenido = nic.getContent();
	  var todoslosvalores = $('#todaedicion :input').serializeArray();
	  var protegido =  escape(contenido);
	  
	  todoslosvalores.push({name:"tipo",value:contexto.model.get("tipo")});
	  todoslosvalores.push({name:"contenido",value:protegido});
	  todoslosvalores.push({name:"articulo_id",value:contexto.model.get("articulo_id")});
	  todoslosvalores.push({name:"receiver",value:"update"}); 

	  $.post("controllers/articulos_controller.php",todoslosvalores,function (response) {
			alert("Actualizado con exito!");
			CharmRouter.navigate("articulos", {trigger:true});
	  });
	},loadColabs:function  () {
		  $('#fechagaleriaeventoedit').datepicker();
		  var contexto = this;
		  var $colaboradoresDOM = $("<select name='colaboradores'></select>");
		setTimeout(function() {
		    $.post('controllers/colaboradores_controller.php',{receiver:true},function(response) {
			  	for (var i = 0; i < response.length; i++) {
			  		var nombre = response[i]['nombrec'];
			  		var id = response[i]['id'];
			  		if (contexto.model.get("colaborador_id") == nombre) {
			  			$colaboradoresDOM.append('<option value="'+id+'" selected="selected">'+nombre+'</option>');
			  		}else{
			  			$colaboradoresDOM.append('<option value="'+id+'">'+nombre+'</option>');		
			  		}
			  	};
			  	$('#colaboradoreselectedit').html($colaboradoresDOM);
			  	$('select').chosen();
			  },'json').fail(function(e) { console.log(e); });
		    var $seccionesDOM = $('<select name="secciones"></select>');
		    $.post('controllers/secciones_controller.php',{receiver:true},function(response) {
		    	for (var i = 0; i < response.length; i++) {
			    	var secnombre = response[i]['nombre'];
			    	var secid = response[i]['id'];
			    	if (contexto.model.get("seccion_id") == secnombre) {
			    		$seccionesDOM.append("<option value='"+secid+"' selected='selected'>"+secnombre+"</option>");
			    	}else{
			    		$seccionesDOM.append("<option value='"+secid+"'>"+secnombre+"</option>");
			    	}
		    	};
		    	$('#seccioneselectedit').html($seccionesDOM);
		    	$('select').chosen();
		    },'json');
    		}, 1000);
	},
	loadStuff:function(){
		var contexto = this;
		$.post("controllers/articulos_controller.php",{receiver:"contenido",articulo:this.model.get("articulo_id")},function  (response) {
			console.log(response);
			$('#contenedoreditar').hide();
			var protegido = contexto.model.get("contenido");
			$('#areaupdate').html(unescape(protegido));

			$.get("controllers/tags_controller.php",function(resi) {
			    	console.log(resi);
			    	for (var i = 0; i < resi.length; i++) {	
			    		$('#tagSelectedit').append("<option value='"+resi[i]['tag_id']+"'>"+resi[i]['nombre']+"</option>");
			    	}
			    	var todos = [];
				for (var i = 0; i < response['tags'].length; i++) {
					var tag = parseInt(response['tags'][i]);
					todos.push(tag);
				};
				console.log(todos);
				$('#tagSelectedit').val(todos);
			},'json');	

			if (typeof response['imagenes']['imagen'] != "undefined") {
				$('#imagenprinciedit').attr("src","Imagenes/"+contexto.model.get("articulo_id")+"/"+response['imagenes']['imagen']+"?timestamp=" + new Date().getTime());
			}
			if (response['imagenes']['imagen'] == "img/ImagenPrinciDefault.png") {
				console.log("jump");
				$('#imagenprinciedit').attr("src",response['imagenes']['imagen']);	
			};
			
			if (typeof response['imagenes']['thumbnail'] != "undefined") {
				$('#tomupdate').attr("src","Thumbnails/"+contexto.model.get("articulo_id")+"/"+response['imagenes']['thumbnail']+"?timestamp=" + new Date().getTime());
			}	
			if (response['imagenes']['thumbnail'] == "img/Tomneil.png") {
				$('#tomupdate').attr("src",response['imagenes']['thumbnail']);	
			};	

			if (typeof response['imagenes']['mascharm'] != "undefined") {
				$('#mascharmupdate').attr("src","MasCharm/"+contexto.model.get("articulo_id")+"/"+response['imagenes']['mascharm']+"?timestamp"+new Date().getTime());
			}
			if (response['imagenes']['mascharm'] == "img/Tomneil.png") {
				$('#mascharmupdate').attr("src",response['imagenes']['mascharm']);	
			};

			switch(contexto.model.get("tipo")){
				case 1:
					$('#contenedoreditar').css("display","block");
					ActivarVinculacionEdicion(contexto.model.get("articulo_id"));
					ActivarSubidaEdicion();
					break;
				case 2:
					$('#videitoedit').css("display","block");
					$('#subirvideoedit').val(response['videourl']);
					break;
			}

			var prinpa = $('#princiupdat').upload({
				name:'principal',
				action:'controllers/articulos_controller.php',
				enctype:'multipart/form-data',
				autoSubmit:true,
				params:{receiver:'updateprincipal',id:contexto.model.get('articulo_id')},
				onComplete:function() {
					var nombre = prinpa.filename();
					var tipo = nombre.substr(nombre.length - 3);
				 	$('#imagenprinciedit').attr('src','Imagenes/'+contexto.model.get('articulo_id')+'/'+contexto.model.get('articulo_id')+"."+tipo+"?timestamp=" + new Date().getTime());
				}
			});

			var prinpo = $('#tomneilupdat').upload({
				name:'thumbnail',
				action:'controllers/articulos_controller.php',
				enctype:'multipart/form-data',
				autoSubmit:true,
				params:{receiver:'updatethumbnail',id:contexto.model.get('articulo_id')},
				onComplete:function() {
					var nombre = prinpo.filename();
					var tipo = nombre.substr(nombre.length - 3);
					$('#tomupdate').attr('src','Thumbnails/'+contexto.model.get('articulo_id')+'/'+contexto.model.get('articulo_id')+"."+tipo+"?timestamp=" + new Date().getTime());
				}
			});		

		  	var updatemascharm = $('#UpdateMasCharm').upload({
				name: 'mascharmupdatefile',
			            action: 'controllers/articulos_controller.php',
			            enctype: 'multipart/form-data',
			            autoSubmit: true,
			            params:{receiver:'updatecharm',generado:contexto.model.get('articulo_id')},
				onComplete:function() {
					var nombre = updatemascharm.filename();
					var tipo = nombre.substr(nombre.length - 3);
				$('#mascharmupdate').attr('src','MasCharm/'+contexto.model.get('articulo_id')+'/'+contexto.model.get('articulo_id')+"."+tipo);				}
			});
			nicEditors.allTextAreas();
		},'json').fail(function  (e) {
			console.log(e);
		});
	},
	render:function  () {
		Handlebars.registerHelper('ifeq', function (a, b, options) {
      			if (a == b) { return options.fn(this); }
    		});
		var contextin = this;
		$.get('templates/EditarArticulo.handlebars',function(data) {
			var template = Handlebars.compile(data);
			var eichtiemel = template(contextin.model.toJSON());
			contextin.$el.html(eichtiemel);
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


function ActivarVinculacionEdicion(idarticulo) {	
   $.post('Galerias/Recibidor.php',{temporaral:idarticulo},function(searmochido) {
  	 	console.log(searmochido);
    }).fail(function(e) {
       console.log(e);
     });
     $.post('Galerias/Recibidor.php',{temporaral:idarticulo},function(searmochido) {
  	 	console.log(searmochido);
    }).fail(function(e) {
       console.log(e);
     });
}

function ActivarSubidaEdicion () {
    $('#formaeditar').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: 'Galerias/index.php'
    });

    // Enable iframe cross-domain access via redirect option:
    $('#formaeditar').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    if (window.location.hostname === 'blueimp.github.com') {
        // Demo settings:
        $('#formaeditar').fileupload('option', {
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
                    .appendTo('#formaeditar');
            });
        }
    } else {
        // Load existing files:
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#formaeditar').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#formaeditar')[0]
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, null, {result: result});
        });
    }
};	

function ActivarVinculacion(jojojo) {	
   $.post('TemporalGalerias/Recibidor.php',{temporaral:jojojo},function(searmochido) {
  	 console.log(searmochido);
    }).fail(function(e) {
       console.log(e);
     });
     $.post('TemporalGalerias/Recibidor.php',{temporaral:jojojo},function(searmochido) {
  	 console.log(searmochido);
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