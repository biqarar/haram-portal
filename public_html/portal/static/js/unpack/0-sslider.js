(function($) {
	$.fn.sslider = function() {
		$(this).each(function() {
			var _self = $(this);
			if($(this).next().is(".ui-sslider")) return;
			$(this).attr('placeholder', '#');
			var _max = $(this).attr('max');
			var _min = $(this).attr('min');
			var _slider = $("<div></div>").addClass('ui-sslider');
			_slider.insertAfter(this).slider({
				// value: parseInt(_self.val()) ? parseInt(_self.val()) : 0,
				slide: function(event, ui) {
					// console.log(_self);
					_self.val(ui.value);
				},
				max: _max,
				min: _min
			});
			$(this).bind('keyup.sslider', function(event) {
				_slider.slider("option", "value", /^\d+$/.test(this.value) ? parseInt(this.value) : 0);
			});
		});
	}
})(jQuery)