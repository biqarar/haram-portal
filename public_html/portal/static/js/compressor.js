var compressor = require('node-minify');
var watch = require('watch');
var fs = require('fs');
var clc = require('cli-color');
var OK = clc.green;
var date = clc.cyan;
var file="main.min.js";

function Compress(){
	var D = new Date();
	new compressor.minify({
		type: 'yui-js',
		fileIn: 'unpack/*.js',
		fileOut: file,
		callback: function(err, min) {
			console.log(OK("\t├── Compress ")+ date(D.getHours()+":"+D.getMinutes()+":"+D.getSeconds()));
		}
	});
}

watch.watchTree('js', function (f, curr, prev) {
	if(fs.existsSync(file)){
		fs.unlinkSync(file);
	}
	Compress();
})
