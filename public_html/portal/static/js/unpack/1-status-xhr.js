(function(){
	var _time = 5;
	var _q = Array();
	var _onq = false;
	var _timeout;
	var _qs = '';
	function status(){
		// if(_onq) return;
		// _onq = true;
		read_status();
	}

	function read_status(){
		var o = _q[0];
		if(!$("#status-xhr")[0])
			$('<div id="status-xhr" class="status-xhr-'+o.type+'">'+_qs+o.title+'</div>').appendTo('body');
		else
			$("#status-xhr").attr('class', 'status-xhr-'+o.type).html(_qs+o.title);
		_q.shift();
		if(_q.length === 0){
			setTimeout(function(){
				if(!_q.length){
					$("#status-xhr").remove();
					_onq = false;
				}else{
					read_status();
				}
			}, _time*1000);
		}else{
			setTimeout(read_status, _time*1000);
		}
	}
	function add(vtitle, vtype){
		_q.push({
			title : vtitle,
			type : vtype
		});
		status();
	}

	function _error(title){
		add(title, 'error');
	}
	function _warn(title){
		add(title, 'warn');
	}
	function _true(title){
		add(title, 'true');
	}
	xhr_error = _error;
	xhr_warn = _warn;
	xhr_true = _true;
})();

function xhr_text(data,type){
	text = "";
		for(a in data[type]){
			if(typeof data[type][a] == "string"){
				text += data[type][a] + ", ";	
			}
		}
	return text;
}

function xhr_result(data){
	// console.log(data);
	if(data.status == 1 ){
		xhr_true(xhr_text(data, "true"));	
	}
	if(data.status == 0){
		xhr_error(xhr_text(data,"fatal"));	
	}
	if(data.status == 2 ){
		xhr_warn(xhr_text(data,"warn"));
	}
}


