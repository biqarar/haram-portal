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

	//tabs
	var tabs = $("#tabs").tabs({
		beforeActivate : function(e, ui){
			var tTab = ui.newTab.attr("aria-controls");
			activeState = (location.hash).replace(/\#/, "");
			if(/^\/?portal\/(.*)$/.test(ui.newTab.find("a").attr("href"))){
				var x = ui.newTab.find("a").attr("href");
				sls_pushState(null, ui.newTab.find("a").text(), x.match(/^\/?portal\/(.*)#(.*)$/)[1]+"#"+tTab);
			}else if(activeState != tTab){
				var tab_href = ui.newTab.find("a").attr("href");
				tab_href = tab_href.replace(/^\.?\/?/,"");
				tab_href = tab_href.replace(/\/$/,"");
				sls_pushState(null, ui.newTab.find("a").text(), tab_href+"#"+tTab);
			}
		},
		beforeLoad : function(e, ui){
			$(ui.panel[0]).sremovecontextmenu();
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
				$(this).sroute(ui.tab.find("a")[0].pathname);
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
		var text = (ui.draggable.text() != '') ? ui.draggable.text() : (ui.draggable.attr('title') != '') ? ui.draggable.attr('title') : '...';
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

// push state
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