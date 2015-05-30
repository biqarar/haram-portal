route(/presence\/classesid\=\d+/, function () {
	$("#presence", this).keyup(function(e){
		username = $("#presence").val();
		classesid = $(this).attr("classesid");
		if(e.keyCode == 13) {
			$.ajax({
				type: "POST",
				url : "presence/apiadd/classesid="+ classesid + "/username=" + username,
				success : function(data){
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
		}
	});

	$(".presence-classes", this).click(function(){
		classesid = $(this).attr("classesid");
		$.ajax({
			type: "POST",
			url : "presence/apiclasses/classesid="+ classesid ,
			success : function(data){
				console.log(data);
				if(data.fatal){
					xhr_error(data.fatal[0]);
				}else if(data.warn){
					xhr_warn(data.warn[0]);
				}else{
					xhr_true(data.true[0]);
				}
				location.reload();
			}
		});
	});
});
