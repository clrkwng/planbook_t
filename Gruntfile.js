module.exports = function (grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            build: {
                src: 'src/<%= pkg.name %>.js',
                dest: 'build/<%= pkg.name %>.min.js'
            }
        },
        clean: {
            bin: [
                'bin/*'
            ],
            deploy: [
                'C:/xampp/htdocs/planbook/*'
            ]
        },
        less: {
            bin: {
                options: {
                    compress: true,
                    yuicompress: true,
                    optimization: 2
                },
                files: {
                    "bin/css/main.css": "testApplication/assets/less/*.less"
                }
            }
        },
        copy: {
            bin: {
                files: [
                    {
                        expand: true,
                        src: ['testApplication/css/**'],
                        dest: 'bin/css/'
                    },
                    {
                        expand: true,
                        src: ['testApplication/ico/**'],
                        dest: 'bin/img/ico/'
                    },
                    {
                        expand: true,
                        src: ['testApplication/img/**'],
                        dest: 'bin/img/'
                    },
                    {
                        expand: true,
                        src: ['testApplication/js/**'],
                        dest: 'bin/scripts/jquery/'
                    },
                    {
                        expand: true,
                        src: [
                            'testApplication/mail/**'
                        ],
                        dest: 'bin/modules/mail/'
                    },
                    {
                        expand: true,
                        src: [
                            'testApplication/template_items/**'
                        ],
                        dest: 'bin/modules/templates/'
                    },
                    {
                        expand: true,
                        src: [
                            'testApplication/*.php',
                            'testApplication/*.html'
                        ],
                        dest: 'bin/modules/'
                    },
                    {
                        expand: true,
                        src: ['node_modules/font-awesome/**'],
                        dest: 'bin/libs/font-awesome/'
                    },
                    {
                        expand: true,
                        src: ['node_modules/jquery/**'],
                        dest: 'bin/libs/jquery/'
                    },
                    {
                        expand: true,
                        src: ['node_modules/bootstrap/**'],
                        dest: 'bin/libs/bootstrap/'
                    }
                ]
            },
            deploy: {
               files: [
                   {
                       expand: true,
                       src: ['bin/**'],
                       dest: 'C:/xampp/htdocs/planbook/'
                   }
               ]
            }
        }
    });

    //Grunt plugins
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-uglify');


    //Build Task Registration
    grunt.registerTask('default',
        ['uglify']
    );
    grunt.registerTask('deploy',
        [
            'copy:deploy'
        ]
    );
};
