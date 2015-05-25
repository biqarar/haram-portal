function certification_api_change(certificationid, type) {
	$.ajax({
		type: "POST",
		url : "certification/apichange/certificationid=" + certificationid + "/type=" + type,
		success : function(data){
			console.log(data);
			xhr_true(data.true[0]);
		}
	});	
}
route(/certification\/status\=api/, function(){
$(".set-date-print",this).click(function(){
	certification_api_change($(this).attr("certificationid"), "setdateprint");
	$(this).removeClass("icocalendar set-date-print").css("cursor","default").html(persian_nu($(this).attr("dateNow")));
});
$(".set-date-deliver",this).click(function(){
	certification_api_change($(this).attr("certificationid"), "setdatedeliver");
	$(this).removeClass("icocalendar set-date-deliver").css("cursor","default").html(persian_nu($(this).attr("dateNow")));
});

});