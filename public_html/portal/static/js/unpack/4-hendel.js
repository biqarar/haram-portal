(function($){
	$.fn.persian_nu = function(en){
		$(this).each(function(){
			var farsi = Array("۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹");
			var english = Array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
			for(n in $(this)[0].childNodes){
				if(!$(this).is('.notp')){
					if($(this)[0].childNodes[n].nodeName == '#text'){
						var _h = $(this)[0].childNodes[n].textContent;
						if(en){
							var _hr = _h.replace(/[۱۲۳۴۵۶۷۸۹۰]/gi, function(){
								return farsi.indexOf(arguments[0]);
							});
						}else{
							var _hr = _h.replace(/\d/gi, function(){
								return farsi[english.indexOf(arguments[0])];
							});
						}
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
	base.find("input[date=date]").each(function(){
		var _self = this;
		$(this).persianDatepicker({
			formatDate:"YYYY-MM-DD",
			isRTL:false,
			onSelect: function() {
				if(_self.callBackDate){
					var fn = _self.callBackDate;
					fn.call(_self);
				}
			}

		});
	});

	base.find("input[time=time]").clockpicker();
	
	base.find("*:not(style)").persian_nu();
	base.find("select:not([name=data_table_length])").selectmenu();
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

	var sesseion = ((Math.random()).toString()).replace(/^\d\./, "");
	base.find('#data_table')
	.on( 'draw.dt', function () {
		$(".dataTables_info").persian_nu();
		$(".dataTables_paginate a").persian_nu();
	})
	.dataTable( {
		"processing": true,
		"serverSide": true,
		"ajax": "users/status=api/session="+sesseion,
		language: {
			processing:     "درحال بارگذاری",
			search:         "جستجو:",
			lengthMenu:    "مقدار _MENU_ سطر",
			info:           "مقدار _START_ تا _END_ از _TOTAL_ سطر",
			infoEmpty:      "هیچ سطری یافت نشد",
			infoFiltered:   "(مقدار _MAX_ بدون فیلتر)",
			infoPostFix:    "",
			loadingRecords: "درحال بارگذاری...",
			zeroRecords:    "هیچ سطری یافت نشد",
			emptyTable:     "هیچ سطری یافت نشد",
			paginate: {
				first:      "نخست",
				previous:   "قبلی",
				next:       "بعدی",
				last:       "آخرین"
			},
			aria: {
				sortAscending:  ": مرتب سازی صعودی",
				sortDescending: ": مرتب سازی نزولی"
			}
		},
		"columns": [
		{ "data": "name" },
		{ "data": "family" },
		{ "data": "father" },
		{ "data": "birthday" },
		{ "data": "gender" },
		{ "data": "nationalcode" },
		{ "data": "code" },
		{ "data": "marriage" },
		{ "data": "education_id" },
		{ "data": "id" },
		{ "data": "id" }
		],
		"order": [[ 9, "asc" ]],
		"lengthMenu": [[10, 25, 50], [10, 25, 50]],
		"createdRow": function ( row, data, index ) {
			var txt;
			var more = $("td",row).eq(9);
			more.persian_nu(true);
			txt = more.text();
			more.html('<a class="icomore ui-draggable ui-draggable-handle" href="users/status=detail/id='+txt+'"></a>');
			$("td", row).persian_nu();

			var edit = $("td",row).eq(10);
			edit.persian_nu(true);
			txt = edit.text();
			edit.html('<a class="icoedit ui-draggable ui-draggable-handle" href="person/status=edit/id='+txt+'"></a>');
			readyState($(row));
		}
	});
}, {onState:true});

ready(function(){
	$("#perload-blockoff").remove();
});

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
