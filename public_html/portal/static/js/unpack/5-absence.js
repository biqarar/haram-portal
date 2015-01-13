route(/absence\/status=classeslist\/classesid=\d+/, function(){
	function l(a) {console.log(a);}

	$(".absence-date-main")[0].callBackDate =  function(){
		date = convert_date($(this).val());
	}

	$("a.insertAbsenceApi", this).click(function(){
		
		if(typeof date == "undefined") {
			xhr_error("تاریخ انتخاب نشده است");
			return false;
		}
		
		classification = $(this).attr("classification");
		classesid = $(this).attr("classesid");
		_self = $(this);
		$.ajax({
			type: "POST",
			url : "absence/api/classification=" + classification + "/date=" + date,
			success : function(data){
				if(data.fatal){
					xhr_error(data.fatal[0]);
					$(_self).removeClass("icodadd").addClass("icoredclose deleteAbsenceApi");
				}else if(data.warn){
					xhr_warn(data.warn[0]);

				}else{
					$(_self).removeClass("icodadd").addClass("icoredclose");
					xhr_true(data.true[0]);
				}
			}
		});		
		return false;
	});

	$("a.deleteAbsenceApi", this).click(function(){
		
		if(typeof date == "undefined") {
			xhr_error("تاریخ انتخاب نشده است");
			return false;
		}
		
		classification = $(this).attr("classification");
		classesid = $(this).attr("classesid");
		_self = $(this);
		$.ajax({
			type: "POST",
			url : "absence/api/classification=" + classification + "/date=" + date,
			success : function(data){
				if(data.fatal){
					xhr_error(data.fatal[0]);
					$(_self).removeClass("icodadd").addClass("icoredclose");
				}else if(data.warn){
					xhr_warn(data.warn[0]);
					
				}else{
					$(_self).removeClass("icodadd").addClass("icoredclose");
					xhr_true(data.true[0]);
				}
			}
		});		
		return false;
	});

	function convert_date(date) {
		date = date.split("-");
		if(date[0].length == 4) y = date[0];
		if(date[1].length != 2) {
			m = "0" + date[1];
		}
		if(date[2].length != 2) {
			d = "0" + date[2];
		}
		return y + "" + m + "" + d;
	}
});	
