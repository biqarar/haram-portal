route(/portal\/hefzlig/, function(){
	var _self = this;
	$( "#lig_id", this).combobox();
	$( "#hefz_team_id_1", this).combobox();
	$( "#hefz_team_id_2", this).combobox();
	$( "#type", this).combobox();
	$("#teachername", this).sautocomplate();

	$(".delete-hefz-teams-users").click(function(){
		teamuserid = $(this).attr("teamuserid");
		_self = $(this);
		$.ajax({
		type: "POST",
		url : "hefzlig/teams/status=apidelete/teamuserid=" + teamuserid ,
		success : function(data){
			
			xhr_result(data);
			$(_self).parents('tr').fadeOut();
		}
		});	
	});
	
});
function hefz_result(raceid,_self){
// console.log(raceid,_self);
	$.ajax({
		type: "POST",
		url : 'hefzlig/racing/status=resultapi/raceid=' + raceid,
		success : function(data){
			// console.log(data);
			for(a in data['msg']['result']){
				// console.log($("#race-result-value-" +a).html())
				$("#race-result-value-" +a).html(persian_nu(data['msg']['result'][a]['value']));
				$("#race-result-result-" +a).html(persian_nu(data['msg']['result'][a]['result']));
				$("#race-result-rate-" +a).html(persian_nu(data['msg']['result'][a]['rate']));
				$("#race-result-manfi-" +a).html(persian_nu(data['msg']['result'][a]['manfi']));	
			}
		}
	});
}

route(/hefzlig\/race\/status\=racing/, function(){

	$(".race-manfi").click(function(){
		_self = $(this);
		teamid = $(this).attr("teamid");
		raceid = $(this).attr("raceid")
		type = $(this).attr("type");
		$.ajax({
			type: "POST",
			url : "hefzlig/race/status=raceapi/teamid=" + teamid + "/raceid=" + raceid +  "/type=" + type,
			success : function(data){
				$(_self).removeAttr('disabled');
				if(data.fatal){
					xhr_result(data);
				}else if(data.warn){
					xhr_result(data);
				}else{
					// $(_true).insertAfter(_self);
					hefz_result(raceid,$(_self));
				}
			}
		});	
		
	});
	$('.race-mark', this).change(function(){
		$(this).attr('disabled', 'disabled');
		_self = $(this);

		teamuserid = $(this).attr("teamusersid");
		raceid = $(this).attr("raceid")
		value = $(this).val();
		type = $(this).attr("name");
		if(value == "" ) {
			$(this).removeAttr('disabled');
			// xhr_error("امتیاز را وارد کنید");
			console.error("امتیاز وارد نشده است");
			return;
		}
		
		_true = '<span class="icolikes" style="margin-right: 5px;padding: 0;display: inline-block;"></span>';
		$(_self).next('span').remove();

		url = "hefzlig/race/status=raceapi/teamuserid=" + teamuserid + "/raceid=" + raceid + "/value=" + value + "/type=" + type;
		
		$.ajax({
			type: "POST",
			url : url,
			success : function(data){
				$(_self).removeAttr('disabled');
				if(data.fatal){
					xhr_result(data);
				}else if(data.warn){
					xhr_result(data);
				}else{
					$(_true).insertAfter(_self);

					hefz_result(raceid,$(_self));
				}
			}
		});		
	});

});
route(/users\/status\=api/, function(){

	$(".add-hefz-teams-users",this).click(function(){
		teamid = $(this).attr("hefzteamsid");
		usersid = $(this).attr("usersid");
		$.ajax({
		type: "POST",
		url : "hefzlig/teams/status=apiadd/usersid=" + usersid + "/teamid=" + teamid,
		success : function(data){
			
			xhr_result(data);
		}
	});	
	})	

	
});


