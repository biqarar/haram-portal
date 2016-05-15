route(/lassification\/status\=edit\/id\=\d+/, function(){
	_self = $(this);
	$("button[value=edit]", this).click(function(){
		usersid = $("#usersid", _self).val();
		classesid = $("#classesid", _self).val();
		id = $("#id", _self).val();
		date_delete = $("#date_delete", _self).val();
		because = $("#because", _self).val();
		$.ajax({
				type: "POST",
				url : "classification/apiprice/usersid=" + usersid + "/classesid=" + classesid,
			success : function(data){
		
				price = data.msg.sum_price;
				console.log(price);
				if(price > 0) {
					sumprice
					$(".question",_self).css("display", "inline-block");
					$("#sumprice",_self).html(price);

					$(".yesprice", _self).click(function(){
						$.ajax({
							type: "POST",
							url : "classification/apipriceback/usersid=" + usersid + "/classesid=" + classesid,
						success : function(data){
							console.log(data);
							$(".question",_self).fadeOut(300);	
							_classification(id, date_delete, because, usersid, classesid, _self);
						}
						});
						
					})
					$(".noprice", _self).click(function(){
						$(".question",_self).fadeOut(300);
							_classification(id, date_delete, because, usersid, classesid, _self);
					})
				}else{
					_classification(id, date_delete, because, usersid, classesid, _self);
				}
			}
			});

		return false;
	});
	function _classification(id, date, because, usersid, classesid, _self){
		console.log("classification/apiclassification/id=" + id + "/date=" + date + "/because=" + because);
		$.ajax({
			type: "POST",
			url : "classification/apiclassification/id=" + id + "/date=" + date + "/because=" + because + "/usersid=" + usersid + "/classesid=" + classesid,
		success : function(data){
			console.log(data);
			xhr_result(data);
		}
		});
		// return false;
		// window.location.reload();
	}
});

// route(/price\/status\=(add|edit)/,function(){
// 	function formatNumber (num) {
// 	 return num.toString().replace(/,/, "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
// 	}
	
// 	$("#value").val(formatNumber($("#value").val()));

// 	$('#value').keyup(function(e) {
// 		_val = $(this).val().replace(/(\,)/, "");
// 		$(this).val("");
// 		$(this).val(formatNumber(_val));
// 	});
// });

// route(/price\/status\=add\/usersid\=\d+/, function(){
// 	_self = $(this);

// 	$("#plan_id",this).combobox( "destroy" );
// 	$("#plan_id", this).combobox({
// 		change : function(op){
// 			item = op.item.option.value
// 			$.ajax({
// 				type: "POST",
// 				url : "plan/api/id=" + item,
// 			success : function(data){
// 				console.log(data);
// 				$("#value", _self).val(data.msg.price);
// 			}
// 			});
// 		}
// 	});
	
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

// // route(/price\/status\=edit\/id\=\d+/, function(){
// // 	_self = $(this);

// // 	// $("#plan_id",this).combobox( "destroy" );
// // 	// $("#plan_id", this).combobox({
// // 	// 	change : function(op){
// // 	// 		item = op.item.option.value
// // 	// 		$.ajax({
// // 	// 			type: "POST",
// // 	// 			url : "plan/api/id=" + item,
// // 	// 		success : function(data){
// // 	// 			console.log(data);
// // 	// 			$("#value", _self).val(data.msg.price);
// // 	// 		}
// // 	// 		});
// // 	// 	}
// // 	// });
	
// // 	$("label[for=plan_id]",_self).fadeOut(1);
// // 	$("#plan_id",_self).next().fadeOut(1);

// // 	$("#common", this).click(function(){
// // 		$("#plan_id,label[for=plan_id]",_self).fadeOut();
// // 		$("#plan_id",_self).next().fadeOut();
// // 		$("#value").val("");
// // 	})
	
// // 	$("#plan").click(function(){
// // 		$("label[for=plan_id]",_self).fadeIn();
// // 		$("#plan_id",_self).next().fadeIn();
		
// // 	});
// // });
