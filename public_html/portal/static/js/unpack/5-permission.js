route(/permission\/status\=api/, function(){
	$(".deletepermission",this).click(function(){

		id = $(this).attr("value");
		_self = $(this);
		console.log(this);
		console.log('permission/apidelete/id=' + id);
		$.ajax({
				type: "POST",
				url : "permission/apidelete/id=" + id ,
			success : function(data){
				xhr_true("سطح دسترسی حذف شد");
				$(_self).parents("tr").fadeOut();
			}
		});
	});
});

route(/permission\/status\=add/, function(){
		$("#branch_id").combobox();
	$(".showbranch",this).click(function(){
		_self = this;
		username = $(".username").val();
		console.log(username);
		$("#branch_id").combobox();
		$("#branch_id").combobox( "destroy" );
		$("#branch_id").combobox({
		create : function(op){

			// console.log(op);
			
			// item = op.item.option.value
			// console.log(item);
			$.ajax({
				type: "POST",
				url : "permission/apishowbranch/username=" + username,
				success : function(data){
					branch_list(data);
					$("#branch_id").combobox();
					// console.log(data);
				}
			});
		}
	});
	});
});

function branch_list (data) {

	$("#branch_id").html('');
	$("#branch_id").val("");
	for(a in data.msg.list) {
		x = data.msg.list[a];
		if(x.name){
	 		$('<option type="text" name="'+x.name+'" value="'+x.branch_id+'" selected="selected" placeholder="'+x.name+'" id="'+x.name+'">'+x.name+'</option>').appendTo("#branch_id");				
		}
	}
}	