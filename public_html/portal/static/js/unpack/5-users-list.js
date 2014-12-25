route("users/status=api", function(url){
	$('tbody>tr', this).attr('copier-context-subject', 'user');
});
route(/classification\/class\/classesid\=\d+/,function(){
	var _self;
	if(this.nodeName == "#document"){
		_self = $('#tabs>div').eq(0);
	}else{
		_self = $(this);
	}
	_self.scontextmenu({
		user : {
			click : function(){
				var id = $(this).attr('id');
				var tabName = $("#tabs>ul>li[aria-controls='"+id+"'] a");
				var href = tabName.attr("href");
				console.log(arguments);
				var usersid = arguments[1][9];
				var name = arguments[1][0] +" "+arguments[1][1];
				var classname = tabName.text();
				var classesid = href.match(/classesid=(\d+)#?.*$/)[1];
				var _xhrUrl = "classification/api/usersid="+usersid+"/classesid="+classesid;
				tabName.removeClass('copier-true').removeClass('copier-error').addClass('copier-load');
				$.ajax({
					type: "POST",
					url : _xhrUrl,
					success : function(data){
						if(data.msg.duplicate){
							xhr_warn(name+" قبلا در "+classname+" ثبت شده است");
						}else if(data.msg.insert) {
							xhr_true(name+" به "+classname+" اضافه شد");
						}else if(data.msg.failed) {
							xhr_error(name+" در "+classname+" ثبت نشد");
						}
					}
				});
			},
			title : function(){
				var id = $(this).attr('id');
				var tabName = $("#tabs>ul>li[aria-controls='"+id+"'] a");
				return 'ثبت در '+tabName.text();
			}
		}
	});
});