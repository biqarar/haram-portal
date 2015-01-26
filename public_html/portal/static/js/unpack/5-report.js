
route(/report\/classes\/status\=apilist/, function(){
	function l(a) {console.log(a);}
	 list = Array();
	$(".list", this).click(function(){
		 index = $(this).attr("classesid");
		 if(list[index]  && list[index] == "ok") {
		 	delete list[index];
		 }else{
		 	list[index] = "ok";
		 }
		l(list);
	});

	$(".start-report").click(function(){
		 newlist = "";
		for (a in list) {
			if(list[a] == "ok") {
				newlist += a + ",";
			}
		}
		$(this).attr("href", "report/classes/status=reportall/classesid=" + newlist);
		// $.ajax({
		// 	type: "POST",
		// 	url : "report/classes/status=reportall/classesid=" + newlist,
		// 	success : function(data){
		// 		// document.write(data);
		// 	}
		// });		
	});
});	