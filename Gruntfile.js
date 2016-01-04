/* 
 * some info:
 * http://robandlauren.com/2014/02/05/live-reload-grunt-wordpress/
 */
module.exports = function (grunt) {
    grunt.initConfig({
        less: {
            development: {
                options: {
                    sourceMap: true
                },
                files: {
                    "assets/css/color-post-slider.css": "assets/less/color-post-slider.less"
                }
            }
        },
        cssmin: {
            target: {
                files: {
                    'assets/css/timeline.min.css': ['assets/css/timeline.css']
                }
            }
        },
        uglify: {
            options: {
                sourceMap: true
            },
            files: {
                src: ['js/color-post-slider.js'],
                dest: 'js/',
                expand: true,
                flatten: true,
                ext: '.min.js'
            }
        },
        watch: {
            options: {
//                livereload: true
            },
            js: {
                files: ['assets/js/*.js'],
                tasks: ['uglify']
            },
            styles: {
                files: ['assets/less/*.less'],
                tasks: ['less']
            },
            mincss: {
                files: ['assets/css/*.css'],
                tasks: ['cssmin']
            },
            php: {
                files: ['**/*.php']
            }
        }
    });
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.registerTask('default', ['less', 'uglify', 'watch']);
};
