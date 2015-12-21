route(/classification\/returnclasses\/id\=\d+/, function(){
	$(".returnclasses", this).click(function(){
		classificationid = $(this).attr("classificationid");
		classesid = $(this).attr("classesid");
		usersid = $(this).attr("usersid");
		$.ajax({
				type: "POST",
				url : "classification/api/usersid="+usersid+"/classesid="+classesid,
			success : function(data) {
				console.log(data);
				if(data.fatal){
					xhr_error(data.fatal[0]);
				}else if(data.warn){
					xhr_warn(data.warn[0]);
				}else{
					xhr_true(data.true[0]);
				}
			}
		});
	});

});
