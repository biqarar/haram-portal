route(/portal\/classes\/status=(add|edit)/, function(){
	var _self = this;
	$( ".select-plan", this).combobox();
	$( ".select-place", this).combobox();
	$("#teachername", this).sautocomplate();
	
});

route(/classes\/status\=done\/classesid\=\d+/, function(){
	$(".classes-done", this).click(function(){
		classesid = $(this).attr("classesid");
		$.ajax({
			type: "POST",
			url : "classes/status=setdone/classesid=" + classesid,

			success : function(data){
				xhr_result(data);
			}
		});
	});
});

route(/classes\/status\=running\/classesid\=\d+/, function(){
	$(".classes-running", this).click(function(){

		classesid = $(this).attr("classesid");
		$.ajax({
			type: "POST",
			url : "classes/status=setrunning/classesid=" + classesid,

			success : function(data){
				xhr_result(data);
			}
		});
	});
});

route(/classes\/status\=move\/classesid\=\d+\/moveto\=\d+/, function(){

	$(".classes-move", this).click(function(){
		xhr_warn("لفطا صبر کنید");
		oldclassesid = $(this).attr("oldclassesid");
		newclasses = $(this).attr("newclasses");
		$.ajax({
			type: "POST",
			url : "classes/status=setmove/classesid=" + oldclassesid + "/moveto="+ newclasses,

			success : function(data){
				xhr_result(data);
			}
		});


	});
});