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

	$("#plan_id",this).combobox( "destroy" );
	$("#plan_id", this).combobox({
		change : function(op){
			item = op.item.option.value
			$.ajax({
				type: "POST",
				url : "plan/api/id=" + item,
				success : function(data){
					console.log(data);
					$("#value", _self).val(data.msg.price);
				}
			});
		}
	});
	
	$("label[for=plan_id]",_self).fadeOut(1);
	$("#plan_id",_self).next().fadeOut(1);

	$("#common", this).click(function(){
		$("#plan_id,label[for=plan_id]",_self).fadeOut();
		$("#plan_id",_self).next().fadeOut();
		$("#value").val("");
	})
	
	$("#plan", _self).click(function(){
		$("label[for=plan_id]",_self).fadeIn();
		$("#plan_id",_self).next().fadeIn();
		
	});

	$("#rule",_self).click(function(){
		var card = $("#card", _self).val();
		var transactions = $("#transactions", _self).val();
		if(card !== 000 && transactions !== 000) {
			$("#card", _self).val("000");
			$("#transactions", _self).val("000");
		}
	});
});

// route(/price\/status\=edit\/id\=\d+/, function(){
// 	_self = $(this);

// 	// $("#plan_id",this).combobox( "destroy" );
// 	// $("#plan_id", this).combobox({
// 	// 	change : function(op){
// 	// 		item = op.item.option.value
// 	// 		$.ajax({
// 	// 			type: "POST",
// 	// 			url : "plan/api/id=" + item,
// 	// 		success : function(data){
// 	// 			console.log(data);
// 	// 			$("#value", _self).val(data.msg.price);
// 	// 		}
// 	// 		});
// 	// 	}
// 	// });
	
// 	$("label[for=plan_id]",_self).fadeOut(1);
// 	$("#plan_id",_self).next().fadeOut(1);

// 	$("#common", this).click(function(){
// 		$("#plan_id,label[for=plan_id]",_self).fadeOut();
// 		$("#plan_id",_self).next().fadeOut();
// 		$("#value").val("");
// 	})
	
// 	$("#plan").click(function(){
// 		$("label[for=plan_id]",_self).fadeIn();
// 		$("#plan_id",_self).next().fadeIn();
		
// 	});
// });
