/**
 * add Evry load ready events
 */
 (function(){
 	var _LOAD = false;
 	var _q = new Array();
 	var _s = new Array();
 	function _ready(f, o){
 		var o = (typeof o === 'object')? o : new Object();
 		if (_LOAD){
 			f.call();
 		}else{
 			_q.push(f);
 		}
 		if(o.onState){
 			_s.push(f.bind(true));
 		}
 	}
 	function _readyState(f){
 		_s.forEach(function(i){
 			i(f);
 		});
 	}
 	window.addEventListener('load', function(){
 		_LOAD = true;
 		_q.forEach(function(i){
 			i();
 		});
 		_q = new Array();
 	});
 	ready = _ready;
 	readyState = _readyState;
 })();