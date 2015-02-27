route(/price/, function(){
	$("#users_id", this).sautocomplate();
	$("#title,#plan_id", this).combobox();
});

route(/price\/status\=(add|edit)/,function(){
	function formatNumber (num) {
	 return num.toString().replace(/,/, "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	}
	
	$("#value").val(formatNumber($("#value").val()));

	$('#value').keyup(function(e) {
		_val = $(this).val().replace(/(\,)/, "");
		$(this).val("");
		$(this).val(formatNumber(_val));
	});
});

route(/price\/status\=add\/usersid\=\d+/, function(){
	_self = $(this);
	
	$("label[for=plan_id]",_self).fadeOut(1);
	$("#plan_id",_self).next().fadeOut(1);

	$("#common", this).click(function(){
		$("#plan_id,label[for=plan_id]",_self).fadeOut();
		$("#plan_id",_self).next().fadeOut();
	})
	
	$("#plan").click(function(){
		$("label[for=plan_id]",_self).fadeIn();
		$("#plan_id",_self).next().fadeIn();
	});
});