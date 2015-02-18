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
function convertDate(date) {
	if(date.test(/^(\d{4})(\-|\/|)(\d{1,2})(\-|\/|)(\d{1,2})$/)) {
		
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
	return data;
}

function mkData(){
	var Data = new Object();
	Data.names = Array();
	Data.values = Array();
	$(this).find("select, input, button, textarea").each(function(){
		var value = false;
		var name = this.name;
		if (name == '_post') return;
		if($(this).is(':radio, :checkbox')){
			if($(this).is(":checked")){
				value = this.value;
			}else{
				value = false;
			}
		}else{
			value = this.value;
		}
		if(value !== false && name != false){
			if(name == 'lists'){
				Data.lists = value;
			}else{
				Data.names.push(name);
				Data.values.push(value);
				// Data.values.push(convertDate(value));
			}
		}
	});
	return Data;
}

route(/report\/price/, function(){
	// alert(0);
	$("#report_form").submit(function(){
		var data = mkData.call(this);
		var string = (location.pathname).replace(/\/$/, '') +'/' + data.lists;
		for(i=0; i< data.names.length; i++){
			string += "/"+data.names[i]+"="+data.values[i];
		}
		// console()
		location.href = string;
		console.log(string);	
		// location.href = "report/classes/type=" + url_ + "/classesid=" + newlist;
		return false;
		// return "report/classes/type=" + url_ + "/classesid=" + newlist;
		$("#report_form").attr("action", "report/classes/type=" + url_ + "/classesid=" + newlist);
		console.log(url_);	
	});
});
