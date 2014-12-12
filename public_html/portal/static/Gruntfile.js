module.exports = function(grunt) {
	var unpackJs = 'js/unpack/';
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		uglify: {
			options: {
				banner: '/** In the name Of Allah\n'+
				' * <%= pkg.name %> \n'+
				' * @author ahmad karimi, reza mohiti, baravak\n'+
				' * @version <%= pkg.version %> <%= grunt.template.today("yyyy-mm-dd") %>\n'+
				' */\n',
				encoding: 'utf8',
				sourceMap: true
			},
			build: {
				src: 'js/unpack/*.js',
				dest: 'js/banoo.min.js'
			}
		},
		sass: {
			dist: {
				files: {
					'css/admin.css' : 'css/admin.scss'
				}
			}
		},
		watch: {
			scripts: {
				files: 'js/unpack/*.js',
				tasks: ['uglify'],
			},
			css: {
				files: 'css/*.scss',
				tasks: ['sass']
			}
		},
	});
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.registerTask('default', ['watch']);
};