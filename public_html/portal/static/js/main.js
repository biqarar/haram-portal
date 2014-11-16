$(document).ready(function() {
	$.ajaxSetup ({
		cache: false
	});
	function transit() {
		var n = $(window).height() + 150;
		var m = n - parseInt($('.menu').css('height'));
		m     = m/2;
		$(".menu").css("top", m);
		$("#tabs>div").css('min-height', ($(window).height() - 225) + "px");
	}
	transit();
	$(window).resize(function() {
		transit();
	}).scroll(function(){
		transit();
	});

	$(".menu>div").each(function() {
		$(this).mouseover(function() {
			$(this).children('.dropdown').stop().fadeIn(200);
		}).mouseout(function() {
			$(this).children('.dropdown').stop().fadeOut(200);
		});
	});

	$("#tabs a").each(function(){
		if(/^#/.test($(this).attr("href"))){
			var href = location.pathname+$(this).attr("href");
			$(this).attr("href", href);
		}
	});

	/**
	 * tabs
	 */
	 var tabs = $("#tabs").tabs({
	 	beforeActivate : function(e, ui){
	 		var tTab = ui.newTab.attr("aria-controls");
	 		activeState = (location.hash).replace(/\#/, "");

	 		if(ui.newTab.find("a").attr("href") == "/portal/#tab-1"){
	 			sls_pushState(null, ui.newTab.find("a").text(), "#"+tTab);
	 		}else if(activeState != tTab){
	 			var tab_href = ui.newTab.find("a").attr("href");
	 			tab_href = tab_href.replace(/^\.?\/?/,"");
	 			tab_href = tab_href.replace(/\/$/,"");
	 			sls_pushState(null, ui.newTab.find("a").text(), tab_href+"#"+tTab);
	 		}
	 	},
	 	beforeLoad : function(e, ui){
	 		transit();

	 		if(ui.tab.is(".loadContentAjax")) return false;
	 		ui.panel.html('<embed src="static/svg/logo-animation.svg" class="perload-svg" height="150" type="image/svg+xml" />');
	 		ui.panel.html = function(data){
	 			ui.tab.addClass("loadContentAjax");
	 			var global = $("<span>"+data+"</span>").find("#global");
	 			global = global.text();
	 			try{
	 				global = $.parseJSON(global);
	 				ui.tab.find("a").html(global.page_title);
	 				$("title").text(global.page_title);
	 				setTabLI(ui.tab);
	 			}catch(e){
	 				global = false;
	 			}
	 			var html = $("<span>"+data+"</span>").find("#content");
	 			$(this).html(html);
	 			readyState($(this));
	 			transit();
	 		};
	 	},
	 	activate : function (e, ui){
	 		$("title").text(ui.newTab.find("a").text());
	 	}
	 });
tabs.find(".ui-tabs-nav li").each(function(){
	setTabLI($(this));
});
tabs.find(".ui-tabs-nav").sortable({
	distance: 30,
	tolerance: "pointer",
	opacity: 0.7,
	sort: function( event, ui ) {
	},
	placeholder: "x4",
	start : function(e, ui){
		if(ui.item.is(".ui-tabs-active")){
			$(".x4").addClass('active');
		}
	},
	stop: function(e, ui) {
		ui.item.css('z-index', '');
		ui.item.css('opacity', 0);
		ui.item.fadeTo('fast', 1);
		tabs.tabs( "refresh");
	}
});

/* close icon: removing the tab on click */
tabs.delegate( "span.ui-icon-close", "click", function() {
	var panelId = $(this).closest("li").fadeOut('fast', function(){
		$(this).remove();
	}).attr( "aria-controls" );
	$( "#" + panelId ).fadeOut('fast', function(){
		$(this).remove();
		tabs.tabs("refresh");
	});
});

$("#tabs>ul").droppable({
	accept: "a",
	drop: function(event, ui) {
		$(".deactive-tab").remove();
		var href = ui.draggable.attr('href');
		var text = ui.draggable.text();
		addTab(href, text);
	},
	over : function(event, ui){
		addTab("#", ui.helper.text(), true);
	},
	out : function(){
		$(".deactive-tab").remove();
	}
});
});


function addTab(href, text, deactive){
	var tab = $("<li><a href='"+href+"'>"+text+"</a></li>");
	$("#tabs").find('.ui-tabs-nav').append(tab);
	if(deactive) tab.addClass("deactive-tab").addClass("ui-state-default");
	if(!deactive) $("#tabs").tabs( "refresh" );
	setTabLI(tab);
}

function setTabLI(ui) {
	var a = ui.find("a");
	if (a.outerWidth() !== a[0].scrollWidth) {
		ui.addClass("dot3");
	}else{
		ui.removeClass("dot3");
	}
	ui.append('<span class="ui-icon ui-icon-close" role="presentation"></span>');
	var text = ui.text();
	text = text.replace(/^\s*/, "");
	text = text.replace(/\s*$/, "");
	ui.attr('title', text);
}

/**
 * add Evry load ready event
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
 function aClickTabs(e){
 	var activeTab, nActive, hash;
 	var href = $(this).attr('href');
 	var text = $(this).text();
 	if($(this).attr("target") == "_blank"){
 		nActive = true;
 	}
 	if(e.button || nActive){
 		addTab(href, text);
 		activeTab = $('#tabs .ui-tabs-nav > li').size() -1;
 		hash = $("#tabs>ul>li").eq(activeTab).attr("aria-controls");
 	}else{
 		activeTab = $("#tabs").tabs('option', 'active');
 		var tab = $("#tabs>ul>li").eq(activeTab).removeClass("loadContentAjax");
 		hash = $("#tabs>ul>li").eq(activeTab).attr("aria-controls");
 		tab.find("a").attr("href", href);
 	}
 	if(e.button || nActive){
 		$( "#tabs" ).tabs({ active: activeTab });
 	}else{
 		$("#tabs").tabs('load', activeTab);
 		sls_pushState(null, text, href+"#"+hash);
 	}

 	return false;
 }
 (function($){
 	$.fn.persian_nu = function(){
 		$(this).each(function(){
 			for(n in $(this)[0].childNodes){
 				if(!$(this).is('.notp')){
 					if($(this)[0].childNodes[n].nodeName == '#text'){
 						var _h = $(this)[0].childNodes[n].textContent;
 						var _hr = _h.replace(/\d/gi, function(){
 							farsi = Array("۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹");
 							english = Array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
 							return farsi[english.indexOf(arguments[0])];
 						});
 						$(this)[0].childNodes[n].textContent = _hr;
 					}
 				}
 			}
 		});
 	}
 })(jQuery);
 $(function(){
 	var sFileboxForm = ".filebox-form";
 	var sFileboxShow = ".filebox";
 	var sFileboxClose = ".filebox-close";
 	var fileboxForm = null;
 	var fileboxM = null;
 	$.fn.filebox = function(){
 		fileboxM = $(this);
 		fileboxForm = $(this).next(fileboxForm);
 		fileboxForm.ajxCall(function(data){
 			$(this).find("[name=base]").val(data.msg.base);
 			$(this).fileboxClose(data);
 		});
 		fileboxForm.find(sFileboxClose).click(function(){
 			$(this).parents("form").fileboxClose();
 		});
 		fileboxM.find(sFileboxShow).fileboxShow();
 	}
 	$.fn.fileboxClose = function(data){
 		var prev = $(this).prev("form");
 		if(data){
 			fileboxM.onFiles(data);
 		}
 		$(this).hide();
 		prev.fadeIn("fast");
 	}
 	$.fn.fileboxShow = function(){
 		$(this).click(function(){
 			var form = $(this).parents("form").next("form");
 			$(this).parents("form").hide();
 			form.fadeIn('fast', function(){
 				$(this).find("input[type='text']")[0].focus();
 			});
 		});
 	}

 	$.fn.onFiles = function(f){
 		if(typeof f === 'function'){
 			$(this).data("onFiles", f);
 		}else if($(this).data("onFiles")){
 			var onFiles = $(this).data("onFiles");
 			onFiles.call(this, f);
 		}
 	}
 });
function imageChangeSize(c){
	console.log(c);
	$(this).find(".img-crop").val(c.x+" "+c.y+" "+c.w+" "+c.h);
}
ready(function(base){
	base = base ? base : $("body");
	base.find('a').not('.ui-tabs-anchor, .a-undefault').draggable({
		helper: "clone",
		snap: "#tabs>ul",
		distance : 20
	}).click(aClickTabs);
	base.find('.ajx').filebox();
	base.find(".posts-form-options").onFiles(function(data){
		var addr = data.msg.publicAddr ? data.msg.publicAddr : data.msg.fileAddr + "."+data.msg.type;
		console.log(addr);
		$(this).find(".img-preview").attr("src", addr);
		var _self = this;
		$(this).find("#postImg").val(data.msg.id);
		if($(this).find('.img-preview').data('Jcrop')){
			var Jcrop = $(this).find('.img-preview').data('Jcrop');
			Jcrop.destroy()
		}
		$(this).find('.img-preview').Jcrop({
			onChange : function(c){
				imageChangeSize.call(_self, c);
			},
			onSelect : function(c){
				imageChangeSize.call(_self, c);
			},
			aspectRatio: 1,
			setSelect : [0, 0, 100, 100],
			bgColor : "#00bbec"
		}, function(){
			$(_self).data('Jcrop', this);
		});
	});
	base.find("#tabs, #tabs li a.ui-tabs-anchor").scroll(function(e){
		this.scrollLeft = 9000;
	});
	base.find("input[date=date]").persianDatepicker({
		formatDate:"YYYY-MM-DD",
		isRTL:false
	});
	base.find("*:not(style)").persian_nu();
	base.find("select").selectmenu();
	base.find(".select-province").on("selectmenuchange", function(event, ui) {
		var CITY = $(this).parents("form").find(".select-city");
		CITY.attr("disabled", "disabled");
		CITY.children(":not(*[disabled='disabled'])").remove();
		var Url = 'city/api/'+ui.item.value;
		$.ajax({
			type: "POST",
			context : CITY,
			url : Url,
			success : function(data){
				// console.log(data);
				if(typeof data === 'object'){
					for(var i = 0; i < data.msg.city.length; i++){
						var city = data.msg.city[i];
						$("<option value='"+city.id+"'>"+city.name+"</option>").appendTo($(this));
					}
				}
				CITY.removeAttr("disabled");
				CITY.selectmenu("refresh");
			}
		});
	});
	base.find(".select-education-group").on("selectmenuchange", function(event, ui) {
		var EDUCATION = $(this).parents("form").find(".select-education-section");
		EDUCATION.attr("disabled", "disabled");
		EDUCATION.children(":not(*[disabled='disabled'])").remove();
		$.ajax({
			context : EDUCATION,
			url : 'education/api/'+ui.item.value,
			success : function(data){
				if(typeof data === 'object'){
					for(var i = 0; i < data.msg.education.length; i++){
						var education = data.msg.education[i];
						$("<option value='"+education.id+"'>"+education.section+"</option>").appendTo($(this));
					}
				}
				EDUCATION.removeAttr("disabled");
				EDUCATION.selectmenu("refresh");
			}
		});
	});
	$("input[name='pasport_date'],label[for='pasport_date']").hide();
	base.find(".select-nationality").on("selectmenuchange", function(event, ui){
		if(ui.item.value != 97){
			$(this).parents("form").find(".select-province").attr("disabled", "disabled").selectmenu("refresh");
			$(this).parents("form").find(".select-city").attr("disabled", "disabled").selectmenu("refresh");
			$(this).parents("form").find("input[name='pasport_date'],label[for='pasport_date']").fadeIn(200);
		}else{
			$(this).parents("form").find(".select-province").removeAttr("disabled").selectmenu("refresh");
			$(this).parents("form").find(".select-city").removeAttr("disabled").selectmenu("refresh");
			$(this).parents("form").find("input[name='pasport_date'],label[for='pasport_date']").fadeOut(200);
		}
	});

	function chChild(){
		if(base.find(".marriage-form:checked").val() == "single"){
			base.find(".children-form").attr("disabled", "disabled");
		}else{
			base.find(".children-form").removeAttr("disabled");
		}
	}
	chChild();
	base.find(".marriage-form").change(chChild);

}, {onState:true});

ready(function(){
	$("#perload-blockoff").remove();
});

/**
 * Push State
 * @param  {[type]} event [description]
 * @return {[type]}       [description]
 */
 function sls_pushState(object, title, url){
 	history.pushState(object, title, url);
 }

 window.onpopstate = function(event) 
 {
 	var oldActive = $("#tabs").tabs('option', 'active');
 	var active_tab;
 	var activeState = (location.hash).replace(/\#/, "");
 	if(activeState){
 		var tab = $("[aria-controls="+activeState+"]");
 		if(tab.length > 0){
 			active_tab = tab.index()
 		}else{
 			active_tab = 0;
 		}
 	}else{
 		active_tab = 0
 	}
 	$( "#tabs" ).tabs({ active: active_tab });
 	if(active_tab == oldActive){
 		href = location.href;
 		href = href.replace(/\#(.*)$/, "");
 		$("#tabs>ul>li").eq(active_tab).find("a").attr("href", href);
 		var tab = $("#tabs>ul>li").eq(active_tab).removeClass("loadContentAjax");
 		$("#tabs").tabs('load', active_tab);
 	}
 };
