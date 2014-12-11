module.exports = function(grunt) {
	var unpackJs = 'js/unpack/*.js';
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		uglify: {
			options: {
				banner: '/** In the name Of Allah\n'+
				' * <%= pkg.name %> \n'+
				' * @author ahmad karimi, reza mohiti, baravak\n'+
				' * @version <%= pkg.version %> <%= grunt.template.today("yyyy-mm-dd") %>\n'+
				' */\n',
				encoding: 'utf8'
			},
			build: [
				{
					src: 'js/unpack/*.js',
					dest: 'js/banoo.min.js'
				},
				{
					src: 'js/lib/*.js',
					dest: 'js/lib.min.js'
				}
			]
		},
		watch: {
			scripts: {
				files: 'js/unpack/*.js',
				tasks: ['uglify'],
			},
		},
	});
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.registerTask('default', ['watch']);
};