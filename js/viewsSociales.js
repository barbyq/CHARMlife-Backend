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
	    CharmRouter.navigate("social/"+hola+"/edit",{trigger:false});
	  });
	},
	loader:function() {	  
		var contexto = this;
		$('#fechita').datepicker();
		ActivarVinculacionSocial(this.iditemporalizador);
		ActivarSubidaSocial();
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
	className:"colab_chisme",
	events:{
		"click .editar":"editar"
	},
	initialize:function  () {
	  this.iditemporalizador = generaidtexto();
	},editar:function  () {
	  var valores = $('#editar :input').serializeArray();
	  valores.push({name:"temporal",value:this.iditemporalizador});
	  valores.push({name:"receiver",value:"registro"});
	  $.post("controllers/sociales_controller.php",valores,function  (response) {
	    alert("Guardado con exito!");
	    CharmRouter.navigate("sociales",{trigger:true});
	  });
	},
	loader:function() {	  
		var contexto = this;
		console.log(this.model.get("imagenes"));
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