route(/course\/courseclasses\/status\=add/, function(){

	$(".courseclasses-item a",this).click(function(){
		$(this).parents(".courseclasses-item").fadeOut(1000);
		return false;
	});
	$("#course_id", this).combobox();
	$("#course_id").combobox( "destroy" );
	$("#course_id", this).combobox({
		change : function(op){
			item = op.item.option.value
			console.log(item);
			$.ajax({
				type: "POST",
				url : "course/courseclasses/apilist/courseid=" + item,
				success : function(data){
					console.log(data);
					$("#courseclasses-list").html('');
					$("#courseclasses-list").val("");

				for(a in data.msg) {
					 if(data.msg[a]['planname']){
					 	$('<span class="courseclasses-item" id="'+ data.msg[a]['id']+'">
							<a class="icoredclose" style="display: inline-block "></a>
							'+
							data.msg[a]['planname'] + "  استاد "
							+data.msg[a]['teacherName'] + " "
							+data.msg[a]['teacherFamily'] +
							'</span>').appendTo("#courseclasses-list");

						 	$(".courseclasses-item a").click(function(){
						 		delete_courseclasses($(this));
						 		$(this).parents(".courseclasses-item").fadeOut(function(){
						 			console.error($(this));
						 		});
								return false;
							});
					 	}

					}
				}
			});
		}
	});
function delete_courseclasses (tag){
console.log(tag)
}

});
