route(/presence\/classesid\=\d+/, function () {
	$("#presence").keyup(function(e){
		username = $("#presence").val();
		classesid = $(this).attr("classesid");
		if(e.keyCode == 13) {
			$.ajax({
				type: "POST",
				url : "presence/apiadd/classesid="+ classesid + "/username=" + username,
				success : function(data){
					console.log(data);
				}
			});
		}
	});
});
