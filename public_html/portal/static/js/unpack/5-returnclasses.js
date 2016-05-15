route(/classification\/returnclasses\/id\=\d+/, function(){
	$(".returnclasses", this).click(function(){
		classesid = $(this).attr("classesid");
		usersid = $(this).attr("usersid");
		$.ajax({
				type: "POST",
				url : "classification/api/usersid="+usersid+"/classesid="+classesid+"/type=returnclasses",
			success : function(data) {
				console.log(data);
				xhr_result(data);
				
			}
		});
	});

});
