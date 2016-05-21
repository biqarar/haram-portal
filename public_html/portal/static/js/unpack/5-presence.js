route(/presence\/classesid\=\d+/, function () {
	$("#presence", this).keyup(function(e){
		username = $("#presence").val();
		classesid = $(this).attr("classesid");
		if(e.keyCode == 13) {
			$.ajax({
				type: "POST",
				url : "presence/apiadd/classesid="+ classesid + "/username=" + username,
				success : function(data){
					xhr_result(data);
				}
			});
		}
	});

	$(".presence-classes", this).click(function(){
		classesid = $(this).attr("classesid");
		$.ajax({
			type: "POST",
			url : "presence/apiclasses/classesid="+ classesid ,
			success : function(data){	
				xhr_result(data);
			}
		});
	});
});
