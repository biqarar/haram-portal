function users_branch_change(type,users_branch_id) {

	if(type == "operator" || type == "student" || type == "teacher" ){
		$(".users-branch-type[usersbranchid="+users_branch_id+"]").fadeOut(10);
	}

	if(type == "waiting" || type == "enable" || type == "block" || type == "delete"){
		$(".users-branch-status[usersbranchid="+users_branch_id+"]").fadeOut(10);
	}
	
	$.ajax({
		type: "POST",
		url : "branch/apichange/usersbranchid=" + users_branch_id + "/type=" + type,
		success : function(data){
			// console.log(data);
			xhr_result(data);
		}
	});	

	if(type == "teacher") xtype = "استاد";
	if(type == "student") xtype = "فراگیر";
	if(type == "operator") xtype = "پرسنل";
	if(type == "waiting") xtype = "در حال انتظار";
	if(type == "enable") xtype = "فعال";
	if(type == "block") xtype = "قفل شده";
	if(type == "delete") xtype = "حذف";

	
	if(type == "operator" || type == "student" || type == "teacher" ){
		$(".users-branch-type[usersbranchid="+users_branch_id+"]").attr("vtext",xtype).html(xtype).val(xtype).fadeIn(1000);
	}
	if(type == "waiting" || type == "enable" || type == "block" || type == "delete"){
		$(".users-branch-status[usersbranchid="+users_branch_id+"]").attr("vtext",xtype).html(xtype).val(xtype).fadeIn(1000);

	}
}

route(/branch\/status\=change\/usersid\=\d+/, function(){
	
	$(".branch-change",this).click(function(){
		id = $(this).attr("usersbranchid");
		type = $(this).attr("type");
		users_branch_change(type, id);
	});
	
});