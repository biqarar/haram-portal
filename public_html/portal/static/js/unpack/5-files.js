route(/portal\/files/, function(){
	var Jcrop_api;
	$("#tag").selectmenu({
		change: function( event, ui ) {
			setResize();
		}
	});
	$( "#type-combo").autocomplete({
		source: function(request, response){
			$.getJSON("person/api/search="+request.term, function(data) {
				response(data.msg.list);
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			$("#id").val(ui.item.id);
		}
	});
	$("#file").change(CheckImageSize);


	function CheckImageSize(){
		var base = $("#image-target");
		var file = this;
		var file = file.files[0];
		var imageType = /image.*/;

		if (file.type.match(imageType)) {
			var reader = new FileReader();

			reader.onload = function(e) {
				base.empty();
				var img = new Image();
				img.src = reader.result;
				base.append(img);
				setResize();
			}

			reader.readAsDataURL(file);	
		}else{
			if(Jcrop_api){
				Jcrop_api.destroy();
			}
			$('#image-target img').remove();
		}
	}
	function imageChangeSize(w, c){
		$("#crop_size").val(c.x+" "+c.y+" "+c.w+" "+c.h+" "+ w);
	}


	function setResize(){
		if(Jcrop_api){
			Jcrop_api.destroy();
		}
		var tag = $("#tag").val();
		var img = $('#image-target img');
		console.log(tag);
		var size_tag = {
			'4' : (1/1)
		}
		if(size_tag[tag]){
			_resize = size_tag[tag];
		}else{
			_resize = (16/9);
		}
		fnChangeSize = imageChangeSize;
		if(img.width() > img.height()){
			img.width(500);
		}else{
			img.height(500);
		}
		fnChangeSize.bind(null, img.width(), img.height());
		img.Jcrop({
			onChange : imageChangeSize.bind(null, img.width()),
			onSelect : imageChangeSize.bind(null, img.width()),
			aspectRatio: _resize,
			setSelect : [0, 0, 160, 160],
			bgColor : "#00bbec"
		},function(){
			Jcrop_api = this;
		});
	}


});