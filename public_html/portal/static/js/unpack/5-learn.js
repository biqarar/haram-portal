route(/listabsence\/status\=xapi\/usersid\=\d/, function(){
	$(".absenceDelete").click(function(){
		classification = $(this).attr("classificationid");
		date = $(this).attr("date");
		_self = $(this);
$.ajax({
	type: "POST",
	url : "absence/apidelete/classification=" + classification + "/date=" + date,
	success : function(data){
		if(data.fatal){
			xhr_error(data.fatal[0]);

		}else if(data.warn){
			xhr_warn(data.warn[0]);

		}else{
			$(_self).parents('tr').fadeOut();
			xhr_true(data.true[0]);
		}
	}
});		
	});
});
