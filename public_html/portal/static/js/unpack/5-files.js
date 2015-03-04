route(/portal\/files/, function(){
	console.log(10);
	$( "#type-combo").autocomplete({
		source: function(request, response){
			$.getJSON("person/api/search="+request.term, function(data) {
				response(data.msg.list);
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			log( ui.item ?
				"Selected: " + ui.item.value + " aka " + ui.item.id :
				"Nothing selected, input was " + this.value );
		}
	});
});