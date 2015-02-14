route(/score/, function(){
	$("#plan_id", this).combobox();
});

route(/score\/classes\/status=apilist\/classesid=\d+\/scoretypeid=\d+/, function(){
	function l(a) {console.log(a);}
	_warn = '<span class="status-warn" style="background: #FFECB3;
			border: 1px solid #FFD54F;
			padding: 3px 10px;
			margin-right: 5px;
			font-size: 12px;
			display: inline-block;">تاریخ ثبت نشده است.</span>';
	_fatal = '<span class="status-fatal" style="background: #FFCDD2;
			border: 1px solid #E57373;
			padding: 3px 10px;
			margin-right: 5px;
			font-size: 12px;
			display: inline-block;">تاریخ ثبت نشده است.</span>';
	_true = '<span class="icolikes" style="margin-right: 5px;padding: 0;display: inline-block;"></span>';

	$('.score-mark', this).change(function(){
		$(this).attr('disabled', 'disabled');
		classificationid = $(this).attr("classificationid")
		scoretypeid = $(this).attr("scoretypeid");
		value = $(this).val();
		if(value == "" ) {
			xhr_error("امتیاز را وارد کنید");
			$(this).removeAttr('disabled');
			return;
		}
		_self = $(this);
		$(_self).next('span').remove();
		$(_self).attr('disabled', 'disabled');
		$.ajax({
			type: "POST",
			url : "score/api/classificationid=" + classificationid + "/scoretypeid=" + scoretypeid + "/value=" + value,
			success : function(data){
				$(_self).removeAttr('disabled');
				if(data.fatal){
					$(_fatal).html(data.fatal[0]).insertAfter(_self);
					// xhr_error(data.fatal[0]);
				}else if(data.warn){
					$(_warn).html(data.warn[0]).insertAfter(_self);
					// xhr_warn(data.warn[0]);
				}else{
					$(_true).insertAfter(_self);
					// xhr_true(data.true[0]);
				}
			}
		});
		$(this).removeAttr('disabled');

		return false;		
	});
});	

route(/score\/calculation\/status\=(add|edit)/, function(){
	$("#plan_id").combobox( "destroy" );
	$("#plan_id", this).combobox({
		change : function(op){
			item = op.item.option.value
			$.ajax({
				type: "POST",
				url : "score/type/api/id=" + item,
			success : function(data){
				console.log(data);
				for(a in data.msg) {
					x = data.msg[a]['title'];
						$("<a href=''>" + x + "</a>").appendTo("#list");
					}
				}
			});
		}
	});
});