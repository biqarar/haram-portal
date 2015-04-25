route(/portal\/files.*type=files/, function(){
	var Jcrop_api;
	$("#file_upload").ajxCall(remove);
	$("#tag").selectmenu({
		change: function( event, ui ) {
			checkType.call($("#file")[0],null, true);
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


	function checkType(event, jump){
		clear_file(jump);
		var base = $("#image-target");
		var file = this;
		var file = file.files[0];
		if(!file) return;
		var imageType = /image.*/;
		if (file.type.match(imageType) && file.size < 10000000) {
			if(jump){
				setResize();
				return;
			}
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
		var _resize;
		$('#image-target').show();
		var tag = $("#tag").val();
		var condition = $("option[value="+tag+"]");
		var img = $('#image-target-img');
		var condition = $("option[value="+tag+"]").attr('data-condition');
		if(condition){
			var parse = parseCondition(condition);
			_resize = (parse.ratio) ? parse.ratio : 1;
		}else{
			_resize = 1;
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

	function clear_file(jump){
		if(!jump)	$("#image-target-img").remove();
		if(Jcrop_api){
			Jcrop_api.destroy();
		}
	}

	function remove(){
		clear_file();
		$('#image-target').hide();
		$("#file").val('');
		$("#file").show();
	}

	$("#remove").click(remove);
});

route(/portal\/files.*type=tag/, function(){
	$("input#width").parents(".form-element").hide();
	$("input#ratio").parents(".form-element").hide();
	$("#type", this).on( "selectmenuchange", function(event, ui) {
		if(ui.item.value == "image"){
			$("input#width").parents(".form-element").fadeIn("fast");
			$("input#ratio").parents(".form-element").fadeIn("fast");
		}else{
			$("input#width").parents(".form-element").fadeOut("fast");
			$("input#ratio").parents(".form-element").fadeOut("fast");
		}
	});
});
