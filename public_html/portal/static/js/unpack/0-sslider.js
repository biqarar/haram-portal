(function($) {
	$.fn.sslider = function() {
		$(this).each(function() {
			var _self = $(this);
			if($(this).next().is(".ui-sslider")) return;
			$(this).attr('placeholder', '#');
			var _max = parseInt($(this).attr('max'));
			var _min = parseInt($(this).attr('min'));
			var _slider = $("<div></div>").addClass('ui-sslider');
			_slider.insertAfter(this).slider({
				value: parseInt(_self.val()) ? parseInt(_self.val()) : 0,
				slide: function(event, ui) {
					_self.val(persian_nu(ui.value));
				},
				max: _max,
				min: _min
			});
			$(this).bind('keyup.sslider', function(event) {
				var val = persian_nu(this.value, true);
				_slider.slider("option", "value", /^[\d]+$/.test(val) ? parseInt(val) : 0);
			});
		});
	}
})(jQuery)