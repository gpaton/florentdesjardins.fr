module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        concat: {
            dist: {
                src: [
                    'static/javascripts/*.js'
                ],
                dest: 'static/javascripts/script.concat.js',
            }
        },

        uglify: {
            build: {
                src: 'static/javascripts/script.concat.js',
                dest: 'static/javascripts/script.min.js'
            }
        },

        watch: {
            scripts: {
                files: [
                    'static/javascripts/*.js',
                    'static/stylesheets/scss/*.scss',
                    'static/stylesheets/scss/partials/*.scss'
                ],
                tasks: [
                    'concat',
                    'uglify',
                    'compass'
                ],
                options: {
                    spawn: false,
                }
            }
        },

        compass: {
            dist: {
                options: {
                    sassDir: 'static/stylesheets/scss',
                    cssDir: 'static/stylesheets'
                }
            }
        },

    });

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-compass');

    grunt.registerTask('default', ['watch']);
};

