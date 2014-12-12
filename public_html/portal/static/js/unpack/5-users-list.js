route("users/status=api", function(url, data){
	$('tbody>tr', this).attr('copier-context-subject', 'user');
	$('tbody>tr', this).data('copire-data', data);
});
route(/classification\/class\/classesid=\d+/,function(){
	var _self;
	if(this.nodeName == "#document"){
		_self = $('#tabs>div').eq(0);
	}else{
		_self = $(this);
	}
	_self.scontextmenu({
		user : {
			click : function(){
				// http://haram.dev/portal/classification/api/usersid=11/classesid=2
				console.log(arguments);
			},
			title : function(){
				return 'کلاس‌بندی';
			}
		}
	});
});

route("*", function(){
	$("[copier-context-subject]").scopier();
});