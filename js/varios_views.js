var OutfitView = Backbone.View.extend({	
	render: function(){
		var context = this;
		var timestamp = $.now();
		var attributes = new Object();
		attributes.outfit = 'outfit.jpg?' + timestamp; 
		attributes = JSON.stringify(attributes);
		console.log(attributes);
		$.get('templates/outfitView.handlebars', function(data){
			template = Handlebars.compile(data);
			context.$el.html(template(attributes));
		});
		//console.log(this);
		return this;
	}
});

