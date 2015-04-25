(function($){
	$.fn.persian_nu = function(en){
		$(this).each(function(){
			var farsi = Array("۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹");
			var english = Array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
			for(n in $(this)[0].childNodes){
				if(!$(this).is('.notp')){
					if($(this)[0].childNodes[n].nodeName == '#text'){
						var _h = $(this)[0].childNodes[n].textContent;
						if(en){
							var _hr = _h.replace(/[۱۲۳۴۵۶۷۸۹۰]/gi, function(){
								return farsi.indexOf(arguments[0]);
							});
						}else{
							var _hr = _h.replace(/\d/gi, function(){
								return farsi[english.indexOf(arguments[0])];
							});
						}
						$(this)[0].childNodes[n].textContent = _hr;
					}
				}
			}
		});
	}
})(jQuery);

function persian_nu(value, en){
	value = value.toString();
	var farsi = Array("۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹");
	var english = Array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
	if(en){
		value = value.replace(/[۱۲۳۴۵۶۷۸۹۰]/gi, function(){
			return farsi.indexOf(arguments[0]);
		});
	}else{
		value = value.replace(/\d/gi, function(){
			return farsi[english.indexOf(arguments[0])];
		});
	}
	if(/^\d+$/.test(value)) value = parseInt(value);
	return value;
}