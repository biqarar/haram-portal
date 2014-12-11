$(document).ready(function() {
	var n = $(window).height() + 150;
	var m = n - parseInt($('.menu').css('height'));
	m     = m/2;
	$('.menu').css({
		"top": m + "px"
	});
	$('#tabs>div').css({
		"min-height": ($(window).height() - 220) + "px",
	});

	$(window).resize(function() {
		transit();
	});

	function transit() {
		var n = $(window).height() + 150;
		var m = n - parseInt($('.menu').css('height'));
		m     = m/2;
		$(".menu").stop().animate({
			top: m
		}, 300, 'linear', function() {
			transit();
		});
		$("#tabs>div").stop().animate({
			'min-height': ($(window).height() - 220) + "px"
		}, 300, 'linear', function() {
			transit();
		})
	}

	$(".menu>div").each(function() {
		$(this).mouseover(function() {
			$(this).children('.dropdown').stop().fadeIn(200);
		}).mouseout(function() {
			$(this).children('.dropdown').stop().fadeOut(200);
		});
	});

	var tabs = $("#tabs").tabs();
	tabs.find("li").each(function(){
		setTabLI($(this));
	});
	tabs.find(".ui-tabs-nav").sortable({
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
		console.log(panelId);
		$( "#" + panelId ).fadeOut('fast', function(){
			$(this).remove();
			tabs.tabs("refresh");
		});
	});

	$('a').not('.ui-tabs-anchor').draggable({
		helper: "clone",
	});
	
	$("#tabs>ul").droppable({
		accept: "a",
		drop: function(event, ui) {
			var href = ui.draggable.attr('href');
			var text = ui.draggable.text();
			var tab = $("<li><a href='"+href+"#tab-4'>"+text+"</a></li>");
			tabs.find('.ui-tabs-nav').append(tab);
			tabs.tabs( "refresh" );
			setTabLI(tab);
			tabs.tabs( "refresh" );
		}
	});

	$("#tabs>ul").droppable({
		accept: "a",
		drop: function(event, ui) {
			var href = ui.draggable.attr('href');
			var text = ui.draggable.text();
			var tab = $("<li><a href='"+href+"#tab-4'>"+text+"</a></li>");
			tabs.find('.ui-tabs-nav').append(tab);
			tabs.tabs( "refresh" );
			setTabLI(tab);
		}
	});

	function setTabLI(ui) {
		var a = ui.find("a");
		if (a.outerWidth() !== a[0].scrollWidth) {
			ui.addClass("dot3");
		}
		ui.append('<span class="ui-icon ui-icon-close" role="presentation"></span>');
		var text = ui.text();
		text = text.replace(/^\s*/, "");
		text = text.replace(/\s*$/, "");
		ui.attr('title', text);
	}

	$( "#speed" ).selectmenu();
});