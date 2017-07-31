module.exports = function (grunt) {

// Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        dirs: {
            src: 'src/files',
            dest: 'style/js',
        },
        sass: {// Task 
            dist: {// Target 
                options: {// Target options 
                    style: 'compressed',
                    sourcemap: 'none'
                },
                files: {// Dictionary of files 
                    'css/style.css': 'css/style.scss'
                }
            }
        },
        // Project configuration. 

        concat: {
            options: {
                separator: ''
            },
            dist: {
                src: ['js2/*/*.js'],
                dest: 'js3/built.js'
            }
        },

        uglify: {
            options: {
                compress: {
                    drop_console: true // <-
                }
            },
            my_target: {
                files: {
                    'js3/built.min.js': ['js3/built.js']
                }
            }
        }

    });
    // Load the plugin that provides the "uglify" task.
    // grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    // Default task(s).
    grunt.registerTask('default', ['sass', 'concat', 'uglify']);
    grunt.registerTask('concat1', ['concat']);
};