(function($){
	$.fn.sautocomplate = function(){
		$(this).each(function(){
			var _url = $(this).attr("url");
			if(!_url) return;
			$(this).autocomplete({
				source: function( request, response ) {
					$.ajax({
						url: _url+"search="+request.term,
						dataType: "jsonp",
						type : 'post',
						success: function( data ) {
							response( data );
						}
					});
				},
				minLength: 1,
				select: function( event, ui ) {
					console.log( ui.item ?
						"Selected: " + ui.item.label :
						"Nothing selected, input was " + this.value);
				},
				open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				},
				close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				}
			});
		});
	}
})(jQuery);