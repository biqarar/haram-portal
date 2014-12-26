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
