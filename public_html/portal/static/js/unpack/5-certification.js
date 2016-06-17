function certification_api_change(certificationid, type) {
	$.ajax({
		type: "POST",
		url : "certification/apichange/certificationid=" + certificationid + "/type=" + type,
		success : function(data){
			
			xhr_result(data);
		}
	});	
}

route(/certification\/status\=api/, function(){

	$(".set-date-print",this).click(function(){
		certification_api_change($(this).attr("certificationid"), "setdateprint");
		$(this).addClass("delete-date-print");
		$(this).removeClass("icocalendar set-date-print").css("cursor","default").html(persian_nu($(this).attr("dateNow")));
	});

	$(".set-date-deliver",this).click(function(){
		certification_api_change($(this).attr("certificationid"), "setdatedeliver");
		$(this).addClass("delete-date-deliver");
		$(this).removeClass("icocalendar set-date-deliver").css("cursor","default").html(persian_nu($(this).attr("dateNow")));
	});

	$(".delete-date-print",this).click(function(){
		certification_api_change($(this).attr("certificationid"), "deletedateprint");
		$(this).removeClass("delete-date-print");
		$(this).addClass("icocalendar set-date-print").css("cursor","pointer").html("");
	});

	$(".delete-date-deliver",this).click(function(){
		certification_api_change($(this).attr("certificationid"), "deletedatedeliver");
		$(this).removeClass("delete-date-deliver")
		$(this).addClass("icocalendar set-date-deliver").css("cursor","pointer").html("");
	});
});