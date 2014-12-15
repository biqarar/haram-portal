(function($){
	$.fn.sautocomplate = function(){
		$(this).each(function(){
			var _url = $(this).attr("data-url");
			if(!_url) return;
			$(this).autocomplete({
				source: function( request, response ) {
					$.ajax({
						url: _url+"search="+request.term,
						dataType: "json",
						type : 'post',
						success: function( data ) {
							response(data.msg.list);
						}
					});
				},
				response : function(event, ui){
					console.log(this);
					return false;
				},
				_renderItem : function(ul, item){
					console.log(10);
					return $( "<li>" )
					.attr( "data-value", item.value )
					.append( item.label )
					.appendTo( ul );
				},
				minLength: 1
			});
		});
	}
})(jQuery);