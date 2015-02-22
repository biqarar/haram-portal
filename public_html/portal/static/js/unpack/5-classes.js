route(/portal\/classes\/status=(add|edit)/, function(){
	var _self = this;
	$( ".select-plan", this).combobox();
	$( ".select-place", this).combobox();
	$("#teachername", this).sautocomplate();
	
});

route(/classes\/status\=done\/classesid\=\d+/, function(){
	$(".classes-done", this).click(function(){
		alert("fuck");
	});
});