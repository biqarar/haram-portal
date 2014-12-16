route(/portal\/person\/status=(add|edit)/, function(){
	var _self = this;
	$("#from", this).sautocomplate();
	var check_disabled = function(value){
		if(value != 97){
			$("#from", _self).next().attr("disabled","disabled");
		}else{
			$("#from", _self).next().removeAttr("disabled");
		}
	}
	$( "#nationality", this).combobox({
		change : function(ui){
			check_disabled(ui.item.option.value);
		},
		create : function(){
			check_disabled(this.value);
		}
	});
	$( "#education_id", this).combobox();
});