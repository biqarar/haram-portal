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

	url_ ="person";
	$("#lists").combobox();
	$("#lists", this).combobox({
		change : function(op){
			url_ = op.item.option.value
		}
	});

	$(".start-reports").submit(function(){
		var _list = returnList();
		var list = Array();
		for(i = 0; i < _list.length; i++) {
			if(_list[i]) list.push(_list[i]);
		}
		newlist = list.join(',');
		$("#report_form").attr("action", "report/classes/type=" + url_ + "/classesid=" + newlist);
		console.log(url_);	
	});


		// console.log("fuck");
	// $("#lists").click(function(){
	// });
});
route(/report\/status\=(add|edit)/, function(){
	$("#tables", this).combobox();
});

route(/report\/classes/, function(){
	// $("#lists").combobox();
	// $("#lists", this).combobox({
	// 	change : function(op){
	// 		item = op.item.option.value
	// 		$(".start-reports",this).
	// 	}
	// });
});
