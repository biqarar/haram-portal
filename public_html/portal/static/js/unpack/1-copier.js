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
				var _append = $("<li>"+_title+"</li>");
				var _activeTab = $("#tabs").tabs('option', 'active');
				contextmenu.append(_append);
				_append.bind('click', function(){
					if(_data.click){
						_data.click.call(_item, $(this), data, subject);
						_hide_contextmenu();
					}
				}).hover(function(){
					$("#tabs>div").each(function(i){
						if(_item[0] == this){
							// $("#tabs").tabs({active: i });
						}
					});
				}, function(){
					// $("#tabs").tabs({active: _activeTab });
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
	$("*").bind('click.scopier contextmenu.scopier', function(){
		$(this).each(function(){
			if(!_oncontextmenu){
				_hide_contextmenu();
			}
			_oncontextmenu = false;
		});
	});
	copiremenuehide = _hide_contextmenu;
})(jQuery);
