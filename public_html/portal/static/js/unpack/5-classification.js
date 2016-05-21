route(/classification\/status\=edit\/id\=\d+/, function(){
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

				if(price > 0) {
					sumprice
					$(".question",_self).css("display", "inline-block");
					$("#sumprice",_self).html(price);

					$(".yesprice", _self).click(function(){
						$.ajax({
							type: "POST",
							url : "classification/apipriceback/usersid=" + usersid + "/classesid=" + classesid,
						success : function(data){
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
		
		$.ajax({
			type: "POST",
			url : "classification/apiclassification/id=" + id + "/date=" + date + "/because=" + because + "/usersid=" + usersid + "/classesid=" + classesid,
		success : function(data){
			xhr_result(data);
		}
		});
	}
});
route(/classification\/status\=api/, function(url){
	$('tbody>tr', this).attr('copier-context-subject', 'user');
});