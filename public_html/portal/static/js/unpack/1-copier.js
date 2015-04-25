(function($){
	var _oncontextmenu = false;
	var _contextmenu;
	var _contextmenu_item = new Object();
	function _remove_contextmenu(){
		if(_contextmenu){
			_contextmenu.remove();
		}
	}

	function _hide_contextmenu(){
		if(_contextmenu){
			_contextmenu.fadeOut(50, _remove_contextmenu);
		}
	}

	function _emptymenue(){
		_contextmenu.append("<li>عملگری وجود ندارد</li>");
	}

	function _show_contextmenu(e){
		_remove_contextmenu();
		var data = $(this).data('copire-data');
		var subject = $(this).attr('copier-context-subject');
		var menu_item = _contextmenu_item[subject];
		var contextmenu = $("<ul></ul>").addClass('copire-contextmenu');
		_contextmenu = contextmenu;
		contextmenu.appendTo('body');
		if(menu_item){
			for(var i = 0; i < menu_item.length; i++){
				if(!menu_item[i]) continue;
				var _item = menu_item[i];
				var _data = _item.data("scontextmenu")[subject];
				var _title = _data.title.call(_item);
				var id = _item.attr('id');
				var _append = $("<li copier-aria-controls='"+id+"'>"+_title+"</li>");
				var _activeTab = $("#tabs").tabs('option', 'active');
				_append.appendTo(contextmenu);
				_append[0].tabNav = $("#tabs>ul>li[aria-controls="+id+"]");
				_append[0].tabPanel = $("#tabs>div#"+id);
				_append.bind('click', function(){
					$("#tabs>ul>li").css({opacity:1});
					if(_data.click){
						var onHide = _data.click.call($(this)[0].tabPanel, $(this), data, subject);
						if(onHide !== false){
							_hide_contextmenu();
						}
					}
				}).hover(function(){
					$("#tabs>ul>li").css({opacity:0.2});
					$(this)[0].tabNav.css({opacity:1});
				}, function(){
					$("#tabs>ul>li").css({opacity:1});
				});
			}
		}
		if($(contextmenu).children("*").length == 0){
			_emptymenue();
		}
		contextmenu.fadeIn('fast');
		contextmenu.bind('contextmenu', function(e) {
			return false;
		});
		contextmenu.bind('click', function(){
			_oncontextmenu = true;
		});
		contextmenu.css({
			top : e.pageY,
			left :e.pageX - contextmenu.outerWidth()
		});
	}
	$.fn.scopier = function(){
		$(this).unbind('contextmenu.scopier');
		$(this).bind('contextmenu.scopier', function(e) {
			_show_contextmenu.call(this, e);
			return false;
		});
	}

	$.fn.sremovecontextmenu = function(){
		_hide_contextmenu();
		$(this).data('scontextmenu', false);
		for(var CI in _contextmenu_item){
			for(var i =0; i < _contextmenu_item[CI].length; i++){
				if(!_contextmenu_item[CI][i]) continue;
				if(this[0] ==  _contextmenu_item[CI][i][0]){
					delete _contextmenu_item[CI][i];
				}
			}
		}
	}

	$.fn.scontextmenu = function(O){
		for(var D in O){
			if(!_contextmenu_item[D]){
				_contextmenu_item[D] = new Array();
			}
			_contextmenu_item[D].push(this);
		}
		$(this).data('scontextmenu', O);
	}
	copiremenuehide = _hide_contextmenu;
	oncontextmenu = function(){
		$("[copier-context-subject]").scopier();
		$('.slider-number').sslider();
		$(this).each(function(){
			if(!_oncontextmenu){
				_hide_contextmenu();
			}
			_oncontextmenu = false;
		});
	}
})(jQuery);

route("*", function(){
	$("*").unbind("click.scopier contextmenu.scopier");
	$("*").bind('click.scopier contextmenu.scopier', oncontextmenu);
});
