(function($) {
	$.fn.sslider = function() {
		$(this).each(function() {
			var _self = this;
			$(this).attr('placeholder', '#');
			var _max = $(this).attr('max');
			var _min = $(this).attr('min');
			var _slider = $("<div></div>").addClass('ui-sslider');
			_slider.insertAfter(this).slider({
				value: _self.value,
				slide: function(event, ui) {
					_self.value = ui.value;
				},
				max: _max,
				min: _min
			});
			$(this).bind('keyup.sslider', function(event) {
				console.log(parseInt(this.value));
				_slider.slider("option", "value", /^\d+$/.test(this.value) ? this.value : 0);
			});
		});
	}
})(jQuery)