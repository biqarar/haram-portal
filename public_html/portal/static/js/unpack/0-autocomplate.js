(function($){
	$.fn.sautocomplate = function(){
		$(this).each(function(){
			var _url = $(this).attr("data-url");
			if(!_url) return;
			var _nself = $(this).clone().removeAttr('name').removeAttr('id').attr('sautocomplate-for', $(this).attr('id') || $(this).attr('name'));
			var _self = this;
			$(this).after(_nself);
			$(this).hide();
			_nself.autocomplete({
				source: function( request, response ) {
					$.ajax({
						url: _url+"search="+request.term,
						dataType: "json",
						type : 'post',
						success: function( data ) {
							response(data.msg.list);
							return false;
						}
					});
				},
				select: function( event, ui ) {
					_self.value = ui.item.value;
					this.value = ui.item.label;
					return false;
				},
				focus: function( event, ui ) {
					_self.value = ui.item.value;
					this.value = ui.item.label;
					return false;
				},
				minLength: 1
			});
		});
	}
})(jQuery);