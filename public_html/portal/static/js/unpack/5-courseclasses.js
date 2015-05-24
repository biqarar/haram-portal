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
					courseclasses_list(data);
					// console.log(data);
				}
			});
		}
	});
});

function courseclasses_list (data) {
		 // <a class="icoredclose" style="display: inline-block" courseclassesid="'+data.msg[a]['id']+'"></a>
	console.log(data);
	$("#courseclasses-list").html('');
	$("#courseclasses-list").val("");
	for(a in data.msg) {
		 if(data.msg[a]['planname']){
		 	$('<span class="courseclasses-item">
		 			<a href="classification/class/classesid='+ data.msg[a]['classes_id'] + '" target="_blank">' +
				data.msg[a]['planname'] + "  استاد "
				+data.msg[a]['teacherName'] + " "
				+data.msg[a]['teacherFamily'] +
				'</a></span>').appendTo("#courseclasses-list");

		}
	}
 	$(".courseclasses-item .icoredclose").click(function(){
 		delete_courseclasses($(this));
 		$(this).parents(".courseclasses-item").fadeOut(function(){
 	});
 // 	$("a.icoredclose", this).hover(function(){
	// 	$(this).parents("span").css("background","red");
	// });
});
}		
function delete_courseclasses(_self){
	// courseclassesid = _self.attr("courseclassesid");
	// $.ajax({
	// 	type: "POST",
	// 	url : "course/courseclasses/apidelete/courseid=" + course_id + '/classesid=' + classes_id,
	// 	success : function(data){
	// 		// console.log(data);
	// 		courseclasses_list(data);
	// 	}
	// });
}

route(/classes\/status\=api\/type\=courseclasses/, function () {
	$(".courseclasses-apiadd" , this).click(function(){
		_self = $(this);
		course_id =$("body #course_id option:selected").attr("value");
		classes_id = $(this).attr("id");
		$.ajax({
			type: "POST",
			url : "course/courseclasses/apiadd/courseid=" + course_id + '/classesid=' + classes_id,
			success : function(data){
				_self.removeClass("icodadd courseclasses-apiadd").addClass("icodadddisable");
				courseclasses_list(data);
			}
		});
	})
});
