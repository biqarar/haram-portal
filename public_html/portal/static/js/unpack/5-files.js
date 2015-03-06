route(/portal\/files/, function(){
	var Jcrop_api;
	$("#tag").selectmenu({
		change: function( event, ui ) {
			checkType.call($("#file")[0]);
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
	$("#file").change(checkType);


	function checkType(){
		clear_file();
		var base = $("#image-target");
		var file = this;
		var file = file.files[0];
		if(!file) return;
		var imageType = /image.*/;
		if (file.type.match(imageType) && file.size < (1024*1024*30)) {
			var reader = new FileReader();

			reader.onload = function(e) {
				var img = new Image();
				img.setAttribute('id', 'image-target-img');
				img.src = reader.result;
				base.append(img);
				setResize();
			}

			reader.readAsDataURL(file);	
		}else{
			var SRC = '';
			if (file.type.match(/^image/)){
				SRC = 'pictures';
			}else if(file.type.match(/^audio/)){
				SRC = 'sound';
			}else if(file.type.match(/^video/)){
				SRC = 'media';
			}else{
				SRC = 'folder';
			}
			var img = new Image();
			img.setAttribute('id', 'image-target-img');
			img.setAttribute('src', 'static/svg/icons/'+SRC+".svg");
			base.append(img);
			$('#image-target').show();
		}
		$("#file").hide();
	}
	function imageChangeSize(w, c){
		$("#crop_size").val(c.x+" "+c.y+" "+c.w+" "+c.h+" "+ w);
	}


	function setResize(){
		$('#image-target').show();
		var tag = $("#tag").val();
		var img = $('#image-target-img');
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

	function clear_file(){
		$("#image-target-img").remove();
		if(Jcrop_api){
			Jcrop_api.destroy();
		}
	}
});