route(/score/, function(){
	$("#plan_id", this).combobox();
});

route(/score\/classes\/status=apilist\/classesid=\d+\/scoretypeid=\d+/, function(){

	$('.score-mark', this).blur(function(){
		$(this).attr('disabled', 'disabled');
		
	});

	function l(a) {console.log(a);}

	$("a.insertAbsenceApi", this).click(function(){
		
		console.log("fuck, fuck");
		l(this);
		l('fuck');
		l(1);

		if(typeof date == "undefined") {
			xhr_error("تاریخ انتخاب نشده است");
			return false;
		}
		
		classification = $(this).attr("classification");
		classesid = $(this).attr("classesid");

		$.ajax({
			type: "POST",
			url : "absence/api/classification=" + classification + "/date=" + date,
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
