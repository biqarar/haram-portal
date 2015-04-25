route(/permission\/status\=api/, function(){
	$(".deletepermission",this).click(function(){

		id = $(this).attr("value");
		_self = $(this);
		console.log(this);
		console.log('permission/apidelete/id=' + id);
		$.ajax({
				type: "POST",
				url : "permission/apidelete/id=" + id ,
			success : function(data){
				xhr_true("سطح دسترسی حذف شد");
				$(_self).parents("tr").fadeOut();
			}
		});
	});
});