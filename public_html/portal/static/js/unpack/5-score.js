route(/score/, function(){
	$("#plan_id", this).combobox();
});

route(/score\/classes\/status=apilist\/classesid=\d+\/scoretypeid=\d+/, function(){
	function l(a) {console.log(a);}

	$('.score-mark', this).blur(function(){
		$(this).attr('disabled', 'disabled');
		classificationid = $(this).attr("classificationid")
		scoretypeid = $(this).attr("scoretypeid");
		value = $(this).val();
		l(value);
		_self = $(this);
		$.ajax({
			type: "POST",
			url : "score/api/classificationid=" + classificationid + "/scoretypeid=" + scoretypeid + "/value=" + value,
			success : function(data){

				if(data.fatal){
					xhr_error(data.fatal[0]);
				}else if(data.warn){
					xhr_warn(data.warn[0]);
				}else{
					xhr_true(data.true[0]);
				}
			}
		});
		$(this).removeAttr('disabled');

		return false;		
	});
});	
