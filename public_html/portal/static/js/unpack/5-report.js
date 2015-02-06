(function(){
	var list = Array();
	function _addToList(id){
		id = parseInt(id);
		if(list.indexOf(id) !== -1) {
			delete list[list.indexOf(id)];
			return false;
		}else{
			list.push(id);
			return true;
		}
	}

	function _returnList(){
		return list;
	}

	addToList = _addToList;
	returnList = _returnList;
})();
route(/report\/classes\/status\=apilist/, function(){
	_list = returnList();
	for(i=0; i< _list.length; i++){
		$('.list[classesid='+_list[i]+']', this).attr('checked', true);
	}
	function _checked(check){
		if(check){
			$(this).attr('checked', true);
		}else{
			$(this).attr('checked', false);
		}
	}
	$(".list", this).parents('tr').click(function(){
		index = $('.list', this).attr("classesid");
		_checked.call($('.list', this), addToList(index));
	});
	$(".start-report").click(function(){
		var _list = returnList();
		var list = Array();
		for(i = 0; i < _list.length; i++) {
			if(_list[i]) list.push(_list[i]);
		}
		newlist = list.join(',');
		$(this).attr("href", "report/classes/status=reportall/classesid=" + newlist);
		// $.ajax({
		// 	type: "POST",
		// 	url : "report/classes/status=reportall/classesid=" + newlist,
		// 	success : function(data){
		// 		// document.write(data);
		// 	}
		// });		
	});
});