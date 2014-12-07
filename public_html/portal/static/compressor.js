var compressor = require('node-minify');
var watch = require('watch');
var fs = require('fs');
var clc = require('cli-color');
var OK = clc.green;
var date = clc.cyan;
var ERROR = clc.red;
var min_file="./js/main.min.js";
var listen_folder = './js/unpack/';
function Compress(){
	var D = new Date();
	new compressor.minify({
		type: 'yui-js',
		fileIn: listen_folder+'*.js',
		fileOut: min_file,
		callback: function(err, min) {
			if(err){
				console.log(ERROR("\t├── "+err));

			}else{
				console.log(OK("\t├── Compress ")+ date(D.getHours()+":"+D.getMinutes()+":"+D.getSeconds()));
			}
		}
	});
}

watch.watchTree(listen_folder, function (f, curr, prev) {
	Compress();
});
