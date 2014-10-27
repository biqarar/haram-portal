/**
@ in the name of Allah
@ author: Baravak @hsbaravak fb.com/hasan.salehi itb.baravak@gmail.com +989356032043
@ version 0.1.0
**/
(function($){
	$.fn.ajx = function(o){
		var _ = new Object();
		_.elements = this;
		function Analist (){
			_.elements.each(function(){
				if($(this).is('a')){
					$(this).unbind('click.state');
					$(this).unbind('click.ajx');
					$(this).bind('click.ajx', function(){
						try{
							SendNav({
								base : this,
								url : $(this).attr('href')
							});
						}catch(e){
							console.log(e.stack);
						}
						return false;
					});
				}else if($(this).is('form')){
					$(this).unbind('click.ajx');
					$(this).bind('submit.ajx', function(){
						try{
							SendFrom({
								base : this,
								url : $(this).attr('action'),
								data : mkData.call(this)
							});
						}catch(e){
							console.log(e.stack);
						}
						return false;
					});
				}
			});
		}

		function mkData(){
			var Data = new FormData()
			$(this).find("select, input, button, textarea").each(function(){
				var value = false;
				var name = this.name;
				if($(this).is(":file")){
					var Files = $(this)[0].files;
					if($(this).attr('multiple')){
						for(var i =0; i < Files.length; i++){
							Data.append(name+'[]', Files[i]);
						}
					}else{
						Data.append(name, Files[0]);
					}
				}else if($(this).is(':radio, :checkbox')){
					if($(this).is(":checked")){
						value = this.value;
					}else{
						value = false;
					}
				}else{
					value = this.value;
				}
				if(value !== false){
					Data.append(name, value);
				}
			});
			return Data;
		}

		function SendNav(O){
			if(o.before){
				o.before(O.base, 'nav');
			}
			$.get(O.url, function(data){
				if(o.after){
					o.after(arguments[2], O.base, 'nav');
				}
				var data;
				try{
					data = $.parseJSON(data);
					if(data.status === 1){
						o.success(data);
						Success(data, O.base);
					}else{
						errorNav(arguments[2]);
					}
				}catch(e){
					errorNav(arguments[2]);
				}
			}).error(errorNav);
			function errorNav(x){
				if(o.after){
					o.after(x, O.base, 'nav');
				}
				if(o.error){
					o.error(x, O.base, 'nav');
				}
			}
		}
		function SendFrom(O){
			if(o.before){
				o.before(O.base, 'form');
			}
			var PL = $('<span class="uploadPerload"></span>');
			var S = $(O.base).find(":submit:eq(0)");
			S.addClass('btn-default');
			S.css({position : 'relative', 'overflow' : 'hidden'});
			PL.appendTo(S);
			var GTOA = $.ajax({
				type : 'POST',
				processData: false,
				contentType: false,
				xhr: function() {
					var req = $.ajaxSettings.xhr();
					if (req) {
						req.upload.addEventListener('progress', function(event) {
							var total = event.totalSize/ (1024*1024);
							var position = event.position/ (1024*1024);
							position = ((position * 100) / total);
							PL.css("width", position+"%");
							$('.progress-bar').css("width", position+"%");
							if (position == 100) {
								PL.addClass('stateUPerlaod');
								PL.removeClass('uploadPerload');
							}
						}, false);
					}
					return req;
				},
				url : O.url,
				data : O.data,
			}).complete(function(x){
				if(o.after){
					o.after(x, O.base, 'form');
				}
				if(x.status == 200){
					try{
						var data = $.parseJSON(x.responseText);
						if(data.status === 1){
							if(o.success){
								o.success(data, O.base);
								Success(data, O.base);
							}
						}else{
							errorForm(x, O.base);
						}
					}catch(e){
						errorForm(x, O.base);
					}
				}
			}).error(function(x){
				errorForm(x, O.base);
			});
			function errorForm(x){
				if(o.error){
					o.error(x, O.base, 'form');
				}
			}
		}
		function Success(data, base){
			if($(base).data('ajxCallBack')){
				$(base).data('ajxCallBack').call(base, data);
			}
		}
		Analist();
		return _;
	}

	$.fn.ajxCall = function(f){
		if(typeof f === 'function'){
			$(this).data("ajxCallBack", f);
		}
	}
})(jQuery);

var O = {
	before: function(base, type){
		if(type == 'form'){
			$(base).find("select, input, button, textarea").attr('disabled','disabled');
		}else if(type == 'nav'){
			var P = $("<span class='statePerlaod'></span>").appendTo($(base));
		}
	},
	after: function(x, base, type){
		if(type == 'form'){
			$(base).find('.stateUPerlaod').remove();
			$(base).find('.uploadPerload').remove();
			$(base).find("select, input, button, textarea").removeAttr('disabled');
		}else if(type == 'nav'){
			$(base).children('.statePerlaod').remove();
		}
		var data = x.responseText;
		try{
			data = $.parseJSON(data);
		}catch(e){
		}
		if(data.msg && data.msg.captcha){
			var c = $(base).find("img[src='captcha.png']");
			c.attr("src", "captcha.png?cid"+(Math.random()));
		}
	},
	success: function(data, base){
		var p = $(base).parents(".ui-tabs-panel");
		$(base)[0].reset();
		p.find(".submit-status").remove();
		var statusDiv = $('<div class="submit-status"></div>');
		statusDiv.insertAfter($(base));
		var D, UL;
		for(D in data){
			if(/^(true|warn)$/i.test(D)){
				UL = $('<ul class="submit-status-'+D+'"></ul>');
				UL.appendTo(statusDiv);
				for(cStatus in data[D]){
					if(!(/^\d+$/.test(cStatus))) continue;
					if(typeof data[D][cStatus] == "object"){
						$('<li>'+data[D][cStatus]['error']+'</li>').appendTo(UL);
					}else{
						console.log(data[D], cStatus);
						$('<li>'+data[D][cStatus]+'</li>').appendTo(UL);
					}
				}
			}
		}
	},
	error: function(x, base, type){
		if(x.status == 0){
			return;
		}
		var data;
		try{
			data = $.parseJSON(x.responseText);
		}catch(e){
			data = x.responseText;
			console.error(data);
		}
		var p = $(base).parents(".ui-tabs-panel");
		p.find(".submit-status").remove();
		var statusDiv = $('<div class="submit-status"></div>');
		statusDiv.insertAfter($(base));
		var D, UL;
		for(D in data){
			if(/^(fatal)$/i.test(D)){
				UL = $('<ul class="submit-status-'+D+'"></ul>');
				UL.appendTo(statusDiv);
				for(cStatus in data[D]){
					if(!(/^\d+$/.test(cStatus))) continue;
					if(typeof data[D][cStatus] == "object"){
						$('<li>'+data[D][cStatus]['error']+'</li>').appendTo(UL);
					}else{
						$('<li>'+data[D][cStatus]+'</li>').appendTo(UL);
					}
				}
			}
		}

	}
}
ready(function(base){
	if(base){
		base.find('.ajx').ajx(O);
	}else{
		$('.ajx').ajx(O);
	}
}, {onState:true});