var ViewRowsociales = Backbone.View.extend({	
	tagName:"tr",
	events:{
		"click .borrar":"borrar"
	},borrar:function(e) {
		var contexto = this;
		var elemento = $(e.currentTarget);
		var id = elemento.attr('id');
		if (confirm("Seguro que quieres borrarlo?")) {
			$.post("controllers/sociales_controller.php",{receiver:"borrar",idsocial:this.model.get("sociales_id")},function  (response) {
				console.log(response);
				contexto.$el.remove();
			});
		};
	},
	render:function  () {
		var contenido = "<td>"+this.model.get("sociales_id")+"</td><td>"+this.model.get("titulo")+"</td><td>"+this.model.get("fecha")+"</td><td>"+this.model.get("descripcion")+"</td><td><a href='#social/"+this.model.get("sociales_id")+"/edit'>Modificar</a></td><td><a id="+this.model.get("sociales_id")+" class='borrar'>Borrar</a></td>";
		this.$el.html(contenido);
		return this;
	}
});

var ViewTablaSociales = Backbone.View.extend({
	tagName:"table",
	className:'colab_edit articulos_main',
	initialize:function() {
	  this.collection.on('add',this.addOne,this);
	  this.collection.on('reset',this.addAll,this);
	},
	addOne:function(social) {
		var socialView = new ViewRowsociales({model: social});
		this.$el.append(socialView.render().el);  
	},
	addAll:function() {
	  this.$el.empty();
	  this.$el.append('<tr><th>Id</th><th>Titulo</th><th>Subtitulo</th><th>descripcion</th><th>Modificar</th><th>Borrar</th></tr>');
	  this.collection.forEach(this.addOne,this);
	},
	render:function() {
	  this.addAll();
	  return this;
	}
});

var RegisterSocialView = Backbone.View.extend({
	id:"registrosocial",
	className:"colab_edit articulos_main",
	events:{
		"click .registrarsocial":"registrarsocial"
	},
	initialize:function  () {
	  this.iditemporalizador = generaidtexto();
	},registrarsocial:function  () {
	  var valores = $('#registrosocial :input').serializeArray();
	  valores.push({name:"temporal",value:this.iditemporalizador});
	  valores.push({name:"usuario_id",value:UserId});
	  valores.push({name:"receiver",value:"registro"});
	  console.log(valores);
	  $.post("controllers/sociales_controller.php",valores,function  (response) {
	    var hola = parseInt(response);
	    CharmRouter.navigate("social/"+hola+"/edit",{trigger:true});
	  });
	},
	loader:function() {	  
		var contexto = this;
		$('#fechita').datepicker();
		ActivarVinculacionSocial(this.iditemporalizador);
		ActivarSubidaSocial();
                $('select').chosen();
    	       var subirprincipal = $('#principalupload').upload({
                   name: 'temporalsocialprincipal',
                   action: 'controllers/sociales_controller.php',
                   enctype: 'multipart/form-data',
                   autoSubmit: true,
                   params:{receiver:'subirprincipal',generado:contexto.iditemporalizador},
                   onComplete:function() {
                   var nombre = subirprincipal.filename();
                   var tipo = nombre.substr(nombre.length - 3);
                   $('#Showprincipal').attr('src','TempSocPrincipal/'+contexto.iditemporalizador+'/'+contexto.iditemporalizador+"."+tipo);
                   }
               });

               var subirthumb = $('#thumbupload').upload({
                   name: 'thumbnailupload',
                   action: 'controllers/sociales_controller.php',
                   enctype: 'multipart/form-data',
                   autoSubmit: true,
                   params:{receiver:'subirthumb',generado:contexto.iditemporalizador},
                   onComplete:function() {
                   var nombre = subirthumb.filename();
                   var tipo = nombre.substr(nombre.length - 3);
                   $('#Showthumb').attr('src','TempThumbSoc/'+contexto.iditemporalizador+'/'+contexto.iditemporalizador+"."+tipo);
                   }
               });
        },
	render:function  () {
		var contexto = this;
		$.get("templates/RegisterSocialView.handlebars",function  (response) {
		  contexto.$el.html(response);
		});
	  return this;
	}
});

var EditSocialView = Backbone.View.extend({
	id:"editar",
	className:"colab_chisme articulos_main",
	events:{
		"click .editar":"editar",
		"click .editardatos":"editardatos"
	},
	initialize:function  () {
	  this.iditemporalizador = generaidtexto();
	},editardatos:function() {
		CharmRouter.navigate("social/"+this.model.get("sociales_id")+"/data",{trigger:true});	
	},
	editar:function  () {
	  var valores = $('#editar :input').serializeArray();
	  valores.push({name:"receiver",value:"edicionfotos"});
	  valores.push({name:"sociales_id",value:this.model.get("sociales_id")})
	  console.log(valores);
	  $.post("controllers/sociales_controller.php",valores,function  (response) {
	     alert("Guardado con exito!");
	     CharmRouter.navigate("sociales",{trigger:true});
	  });
	},
	loader:function() {	  
		var contexto = this;
	},
	render:function  () {
		var contexto = this;
		$.get("templates/EditSocial.handlebars",function  (response) {
		  var cn = Handlebars.compile(response);
		  var eichtiemel = cn(contexto.model.toJSON());
		  contexto.$el.html(eichtiemel);
		});
	  return this;
	}
});

var EditDataSocialView = Backbone.View.extend({
	id:"editdata",
	className:"colab_edit articulos_main",
	events:{
		"click .reditdata":"reditdata"
	},
	initialize:function  () {
	  this.iditemporalizador = generaidtexto();
	},reditdata:function  () {
	  var contexto = this;
	  var valores = $('#editdata :input').serializeArray();
	  valores.push({name:"receiver",value:"updatedatasocial"});
	  valores.push({name:"usuario_id",value:UserId});
	  valores.push({name:"sociales_id",value:this.model.get("sociales_id")});
	  console.log(valores);
	  $.post("controllers/sociales_controller.php",valores,function (response) {
	     alert("Guardado con exito!");
	     CharmRouter.navigate("social/"+contexto.model.get("sociales_id")+"/edit",{trigger:true});
	  });
	},
	loader:function() {	  
		var contexto = this;
		$('#fechita').datepicker();
		ActivarVinculacionDataEdit(this.model.get("sociales_id"));
		ActivarSubidaDataEdit(this.model.get("sociales_id"));
                $('select').chosen();
                $.post("controllers/sociales_controller.php",{receiver:"damedatos",socialesid:this.model.get("sociales_id")},function(response) {
                    console.log(response);
                    $('#Showprincipaledit').attr("src",response['principal']);
                    $('#Showthumbedit').attr("src",response['thumbnail']);

                    var princiedit = $('#principaluploadedit').upload({
                        name: 'principaledit',
                        action: 'controllers/sociales_controller.php',
                        enctype: 'multipart/form-data',
                        autoSubmit: true,
                        params:{receiver:'editarprinci',generado:contexto.model.get("sociales_id")},
                        onComplete:function() {
                            var nombre = princiedit.filename();
                            var tipo = nombre.substr(nombre.length - 3);
                            $('#Showprincipaledit').attr('src','SocPrincipal/'+contexto.model.get("sociales_id")+'/'+contexto.model.get("sociales_id")+"."+tipo);
                        }
                    });

                    var thumbedit = $('#thumbuploadedit').upload({
                        name: 'thumbedit',
                        action: 'controllers/sociales_controller.php',
                        enctype: 'multipart/form-data',
                        autoSubmit: true,
                        params:{receiver:'editarthumb',generado:contexto.model.get("sociales_id")},
                        onComplete:function() {
                            var nombre = thumbedit.filename();
                            var tipo = nombre.substr(nombre.length - 3);
                            $('#Showthumbedit').attr('src','SocThumb/'+contexto.model.get("sociales_id")+'/'+contexto.model.get("sociales_id")+"."+tipo);
                        }
                    });

                },'json');
	},
	render:function  () {
		var contexto = this;
                Handlebars.registerHelper('ifeq', function (a, b, options) {
                    if (a == b) { return options.fn(this); }
                });
		$.get("templates/EditSocialData.handlebars",function  (response) {
		  var cn = Handlebars.compile(response);
		  var eichtiemel = cn(contexto.model.toJSON());
		  contexto.$el.html(eichtiemel);
		});
	  return this;
	}
});

function ActivarVinculacionDataEdit(socialedit) {	
   $.post('Sociales/Recibidor.php',{temporaral:socialedit},function(searmochido) {
  	 	console.log(searmochido);
  	 	console.log("lo mande aca chido");
    }).fail(function(e) {
       console.log(e);
     });
     $.post('Sociales/Recibidor.php',{temporaral:socialedit},function(searmochido) {
  	 	console.log(searmochido);
  	 	console.log("lo mande aca chido");
    }).fail(function(e) {
       console.log(e);
     });
}

function ActivarSubidaDataEdit (socialid) {
    $('#socialuploadedit').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: 'Sociales/index.php'
    });

    $('#socialuploadedit').bind("fileuploaddone",function  (e,data) {
    	console.log(e);
    	console.log(data);
    	for (var i = 0; i < data['result']['files'].length; i++) {
    		var nombre = data['result']['files'][i]['name'];
    		$.post("controllers/sociales_controller.php",{receiver:"agregafotosocial",foto:nombre,social_id:socialid},function (response) {
    			console.log(response);
    		});
    		console.log(nombre);
    	};
    	console.log("Subi algo aca chido");
    }).bind('fileuploaddestroyed', function (e, data) {
    	console.log(data);
        console.log("borrando");
    	var archivoborradin = data['url'].substring(50,data['url'].indexOf("&"));
    	$.post("controllers/sociales_controller.php",{receiver:"borrarfoto",social_id:socialid,foto:archivoborradin},function  (response) {
    	   console.log(response);
    	}).fail(function(e) {
            console.log(e);
        });
    });
    // Enable iframe cross-domain access via redirect option:
    $('#socialuploadedit').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    if (window.location.hostname === 'blueimp.github.com') {
        // Demo settings:
        $('#socialuploadedit').fileupload('option', {
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
                    .appendTo('#socialuploadedit');
            });
        }
    } else {
        // Load existing files:
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#socialuploadedit').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#socialuploadedit')[0]
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, null, {result: result});
        });
    }
}	

function ActivarVinculacionSocial(social) {	
   $.post('TemporalSociales/Recibidor.php',{temporaral:social},function(searmochido) {
  	 	console.log(searmochido);
  	 	console.log("lo mande aca chido");
    }).fail(function(e) {
       console.log(e);
     });
     $.post('TemporalSociales/Recibidor.php',{temporaral:social},function(searmochido) {
  	 	console.log(searmochido);
  	 	console.log("lo mande aca chido");
    }).fail(function(e) {
       console.log(e);
     });
}

function ActivarSubidaSocial () {
    $('#socialupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: 'TemporalSociales/index.php'
    });

    // Enable iframe cross-domain access via redirect option:
    $('#socialupload').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    if (window.location.hostname === 'blueimp.github.com') {
        // Demo settings:
        $('#socialupload').fileupload('option', {
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
                    .appendTo('#socialupload');
            });
        }
    } else {
        // Load existing files:
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#socialupload').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#socialupload')[0]
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, null, {result: result});
        });
    }
}