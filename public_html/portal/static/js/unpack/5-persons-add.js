route(/portal\/person\/status=(add|edit)/, function(){
	var _self = this;
	$("#from", this).sautocomplate();
	var check_disabled = function(value){
		if(value != 97){
			$("#from", _self).next().attr("disabled","disabled");
			$("#pasport_date,label[for='pasport_date']").fadeIn();
			// console.log($("#pasport_date"));
		}else{
			$("#from", _self).next().removeAttr("disabled");
			$("#pasport_date,label[for='pasport_date']").fadeOut();

			// console.log($("#pasport_date"));


		}
	}
	var OBJ = {
		change : function(ui){
			check_disabled(ui.item.option.value);
		},
		create : function(){
			check_disabled(this.value);
		}
	};
	$( "#nationality", this).combobox(OBJ);
	
	$( "#education_id", this).combobox();
	$( "#education_howzah_id", this).combobox();
});
route(/portal\/person\/status=edit/, function(){
	$(".ajx", this).ajxOptions({
		reset : false
	});
});
route("*", function(){
	$('.slider-number').sslider();
});