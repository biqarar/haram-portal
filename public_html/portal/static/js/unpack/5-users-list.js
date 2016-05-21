route(/users\/status=api/, function(url){
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
				xhr_true("لطفا کمی صبر کنید...");
				var id = $(this).attr('id');
				var tabName = $("#tabs>ul>li[aria-controls='"+id+"'] a");
				var href = tabName.attr("href");
				
				var usersid = arguments[1][9];
				var name = arguments[1][0] +" "+arguments[1][1];
				var classname = tabName.text();
				var classesid = href.match(/classesid=(\d+)#?.*$/)[1];
				var _xhrUrl = "classification/api/usersid="+usersid+"/classesid="+classesid+"/type=add";
				tabName.removeClass('copier-true').removeClass('copier-error').addClass('copier-load');
	
				$.ajax({
					type: "POST",
					url : _xhrUrl,
					success : function(data){
						xhr_result(data);
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