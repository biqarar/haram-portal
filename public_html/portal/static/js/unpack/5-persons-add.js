route("portal/person/status=add", function(){
	$("#from" ).sautocomplate();
	var check_disabled = function(value){
		if(value != 97){
			$("#from").next().attr("disabled","disabled");
		}else{
			$("#from").next().removeAttr("disabled");
		}
	}
	$( "#nationality" ).combobox({
		change : function(ui){
			check_disabled(ui.item.option.value);
		},
		create : function(){
			check_disabled(this.value);
		}
	});
	$( "#education_id" ).combobox();
});