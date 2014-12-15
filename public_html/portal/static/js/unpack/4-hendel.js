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
	}).bind('click', aClickTabs);
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
	base.find("select:not([name=data_table_length], .notselect)").selectmenu();
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
			$(this).parents("form").find(".select-city").attr("disabled", "disabled").selectmenu("refresh");
			$(this).parents("form").find("input[name='pasport_date'],label[for='pasport_date']").fadeIn(200);
		}else{
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
