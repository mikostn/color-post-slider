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
                    'assets/css/color-post-slider.min.css': ['assets/css/color-post-slider.css']
                }
            }
        },
        uglify: {
            options: {
                sourceMap: true
            },
            files: {
                src: ['assets/js/color-post-slider.js'],
                dest: 'assets/js/',
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
                files: ['assets/js/color-post-slider.js'],
                tasks: ['uglify']
            },
            styles: {
                files: ['assets/less/color-post-slider.less'],
                tasks: ['less']
            },
            mincss: {
                files: ['assets/css/color-post-slider.css'],
                tasks: ['cssmin']
            },
            php: {
                files: ['**/*.php']
            }
        },
        mkdir: {
            all: {
                options: {
                    create: ['dist']
                }
            }
        },
        compress: {
            main: {
                options: {
                    archive: 'color-post-slider.zip'
                },
                expand: true,
                src: [
                    'assets/**',
                    'includes/*',
                    'index.php',
                    'color-post-slider.php',
                    'LICENSE',
                    'readme.txt'
                ],
                dest: 'color-post-slider/'
            }
        },
        rename: {
            main: {
                files: [
                    {src: ['color-post-slider.zip'], dest: 'dist/color-post-slider.zip'}
                ]
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.registerTask('default', ['less', 'uglify', 'watch']);

    grunt.loadNpmTasks('grunt-contrib-compress');
    grunt.loadNpmTasks('grunt-mkdir');
    grunt.loadNpmTasks('grunt-contrib-rename');
    grunt.registerTask('package', ['less', 'uglify', 'cssmin', 'mkdir', 'compress', 'rename']);
};
