function log(a){
	console.log(a);
}
(function ($) {
	$.fn.acomplete = function(url, limit, index, fields) {
		log(fields);
		url = (url !== null || url !== "default") ? url : 'autocomplete/assoc/';
		var autoSource = new Array();
		log(url);
		$.ajax({
			type: "POST",
			url: url,
		}).done(function(data) {
			log(data);
			data = data.msg[index];
			if(data.length > 0){
				for(var i = 0; i < data.length; i++){
					for (var j = 0; j < fields.length; j++) {
						autoSource[i] += data[i][fields[j]] + ' ';
					}
				}	
			}
		});
		$(this).autocomplete({
			source: autoSource
		})
	};
}(jQuery));