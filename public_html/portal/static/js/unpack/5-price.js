route(/price/, function(){
	$("#users_id", this).sautocomplate();
	$("#title", this).combobox();
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