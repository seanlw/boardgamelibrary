module.exports = function(grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
    
        watch: {
            files: ['sass/*.scss', 'js/*.js'],
            tasks: ['sass:dev', 'uglify:dev']
        },
        sass: {
            dev: {
                options: {
                    style: 'compressed'
                },
                files: {
                    '../app/webroot/css/<%= pkg.name %>.min.css': 'sass/<%= pkg.name %>.scss'
                }
            }
        },
        uglify: {
            dev: {
                src: 'js/*.js',
                dest: '../app/webroot/js/<%= pkg.name %>.min.js'
            }
        }
    });
    grunt.registerTask('default', 'sass:dev');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-uglify');
}