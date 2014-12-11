/**
 * [description]
 * @return {[type]} [description]a
 */
(function (){
	var _routes = new Object();
	_routes.length = 0;
	function _route(){
		var fn, index;
		var args = arguments;
		index = _routes.length++;

		if(typeof args[args.length-1] != 'function') return;
		fn = args[args.length-1];

		for (var i = 0; i < args.length -1 ; i++) {
			if(!_routes[index]){
				_routes[index] = new Object();
				_routes[index].routes = new Array();
				_routes[index].fn = fn;
			}
			_routes[index].routes.push(args[i]);
		}
	}

	function main(base){
		var url;
		url = ((location.pathname).replace(/^\//,"")).replace(/\/$/, "");
		for(var i = 0; i < _routes.length; i++){
			var  oRoute = _routes[i];
			for (var iRoute in oRoute.routes ){

				var condition = oRoute.routes[iRoute];
				if(condition == '*'){
					_call(base, oRoute, url);
				}else if(typeof condition == 'string' && condition == url){
					_call(base, oRoute, url);
				}else if(typeof condition == 'object' && condition.test(url)){
					_call(base, oRoute, url);
				}
			}
		}
	}

	function _call(base, oRoute){
		var fn = oRoute.fn;
		fn.call(base);
	}

	$(document).ready(function(){
		main(document);
	});
	route = _route;
	route_main = main;
})();
(function($){
	$.fn.sroute = function(){
		$(this).each(function(){
			route_main(this);
		});
	}
})(jQuery);