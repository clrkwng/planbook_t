module.exports = function (grunt) {

    var xamppDir = "C:/Users/andrew.parise/Projects/3rdParty/xampp";

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        resourcesPath: 'src/Planbook/AppBundle/Resources',
        adminResourcesPath: 'src/Planbook/AdminBundle/Resources',

        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            build: {
                src: 'src/<%= pkg.name %>.js',
                dest: 'build/<%= pkg.name %>.min.js'
            }
        },

        shell: {
            cache_clear_prod: {
                options: {
                    stdout: true
                },
                command: 'php bin/console cache:clear --env=prod --no-debug'
            },
            composer_dump_autoload: {
                options: {
                    stdout: true
                },
                command: 'composer dump-autoload --optimize'
            }
        },

        clean: {
            options: { force: true },
            js_app: ['web/js/app/*'],
            img_app: ['web/img/*'],
            js_app_build: ['web/js-app-build'],
            js_admin: ['web/js/admin/*'],
            js_admin_build: ['web/js-admin-build'],
            css_app: ['web/css/app/*'],
            css_admin: ['web/css/admin/*'],
            xampp: [
                xamppDir + '/htdocs/planbook/*'
            ]
        },
        less: {
            app: {
                options: {
                    paths: ['<%= resourcesPath %>/public/less'],
                    compress: true
                },
                files: {
                    'web/css/app/style.min.css': '<%= resourcesPath %>/public/less/style.less'
                }
            },
            admin: {
                options: {
                    paths: ['<%= adminResourcesPath %>/public/less'],
                    compress: true
                },
                files: {
                    'web/css/admin/style.min.css': '<%= adminResourcesPath %>/public/less/style.less'
                }
            }
        },
        properties: {
            xampp: [
                'application/config/profiles/dev/base.properties',
                'application/config/profiles/dev/windows.properties'
            ]
        },
        copy: {
            js_app: {
                expand: true,
                cwd: '<%= resourcesPath %>/public/js/',
                src: '**',
                dest: 'web/js/app'
            },
            js_app_build: {
                expand: true,
                cwd: 'web/js-app-build/',
                src: '**',
                dest: 'web/js/app'
            },
            js_admin: {
                expand: true,
                cwd: '<%= adminResourcesPath %>/public/js/',
                src: '**',
                dest: 'web/js/admin'
            },
            js_admin_build: {
                expand: true,
                cwd: 'web/js-admin-build/',
                src: '**',
                dest: 'web/js/admin'
            },
            img_app: {
                expand: true,
                cwd: '<%= resourcesPath %>/public/img/',
                src: '**',
                dest: 'web/img'
            },
            xampp: {
                files: [
                   {
                       expand: true,
                       src: [
                           'web/*',
                           'src/Planbook/AppBundle/*',
                           'app/*'
                       ],
                       dest: xamppDir + '/htdocs/planbook/'
                   }
               ]
            }
        },

        requirejs: {
            compile_app: {
                options: {
                    mainConfigFile: 'web/js/app/main.js',
                    baseUrl: './',
                    appDir: 'web/js/app',
                    dir: 'web/js-app-build',
                    removeCombined: true,
                    findNestedDependencies: true,
                    modules: [
                        { name: 'main' },
                        { name: 'pages/home', exclude: ['main'] },
                        { name: 'pages/orderCheckout', exclude: ['main'] },
                        { name: 'pages/productDetail', exclude: ['main'] },
                    ],
                    done: function(done, output) {
                        grunt.file.delete('web/js-app-build/build.txt', { force: true});
                        done();
                    }
                }
            },
            compile_admin: {
                options: {
                    mainConfigFile: 'web/js/admin/main.js',
                    baseUrl: './',
                    appDir: 'web/js/admin',
                    dir: 'web/js-admin-build',
                    removeCombined: true,
                    findNestedDependencies: true,
                    wrapShim: true,
                    modules: [
                        { name: 'main' },
                        { name: 'pages/accountForm', exclude: ['main'] },
                        { name: 'pages/administratorForm', exclude: ['main'] },
                        { name: 'pages/orderDetail', exclude: ['main'] },
                        { name: 'pages/productDetail', exclude: ['main'] }
                    ],
                    done: function(done, output) {
                        grunt.file.delete('web/js-admin-build/build.txt', { force: true});
                        done();
                    }
                }
            }
        },

        watch: {
            less_app: {
                files: '<%= resourcesPath %>/public/less/**/*.less',
                tasks: ['clean:css_app', 'less:app']
            },
            less_admin: {
                files: '<%= adminResourcesPath %>/public/less/**/*.less',
                tasks: ['clean:css_admin', 'less:admin']
            },
            js_app: {
                files: '<%= resourcesPath %>/public/js/**/*.js',
                tasks: ['clean:js_app', 'copy:js_app']
            },
            js_admin: {
                files: '<%= adminResourcesPath %>/public/js/**/*.js',
                tasks: ['clean:js_admin', 'copy:js_admin']
            },
            css: {
                files: 'web/css/**/*.css',
                tasks: [],
                options: {
                    livereload: true
                }
            },
            img_app: {
                files: '<%= resourcesPath %>/public/img/*',
                tasks: ['clean:img_app', 'copy:img_app'],
                options: {
                    livereload: true
                }
            }
        },

        'string-replace': {
            bin: {
                files: [{
                    expand: true,
                    cwd: 'bin/',
                    src: '**/*.php',
                    dest: 'bin/'
                }],
                options: {
                    replacements: [
                        {
                            pattern: '{db.host}',
                            replacement: '<%= windows.dbHost %>'
                        },
                        {
                            pattern: '{db.name}',
                            replacement: '<%= windows.dbName %>'
                        },
                        {
                            pattern: '{db.user}',
                            replacement: '<%= windows.dbUser %>'
                        },
                        {
                            pattern: '{db.password}',
                            replacement: '<%= windows.dbPassword %>'
                        }
                    ]
                }
            }
        },
        phpdoc: {
            options: {
                verbose: true
            },
            src: [
                'src/AppBundle/'
            ],
            dest: 'doc/App'
        }
    });

    //Grunt plugins
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-properties-reader');
    grunt.loadNpmTasks('grunt-string-replace');
    grunt.loadNpmTasks('grunt-phpdoc');
    grunt.loadNpmTasks('grunt-shell');
    grunt.loadNpmTasks('grunt-contrib-requirejs');
    grunt.loadNpmTasks('grunt-contrib-watch');

    //Build Task Registration
    grunt.registerTask('default', function() {
        grunt.task.run("clean");
        grunt.task.run("less");
        grunt.task.run("copy:js_app");
        grunt.task.run("copy:img_app");
        grunt.task.run("copy:js_admin");
    });

    grunt.registerTask('xampp-deploy',
        [
            'clean:xampp',
            'copy:xampp'
        ]
    );

    grunt.registerTask('dev', ['default', 'watch']);

    grunt.registerTask('optimizejs', function() {
        grunt.task.run("clean:js_app");
        grunt.task.run("clean:js_admin");
        grunt.task.run("copy:js_app");
        grunt.task.run("copy:js_admin");
        grunt.task.run("requirejs");
        grunt.task.run("clean:js_app");
        grunt.task.run("clean:js_admin");
        grunt.task.run("copy:js_app_build");
        grunt.task.run("clean:js_app_build");
        grunt.task.run("copy:js_admin_build");
        grunt.task.run("clean:js_admin_build");
    });

    grunt.registerTask('prod', function() {
        grunt.task.run("clean");
        grunt.task.run("less");
        grunt.task.run("shell:cache_clear_prod");
        grunt.task.run("shell:composer_dump_autoload");
        grunt.task.run("optimizejs");
    });

    grunt.registerTask('documentation',
        [
            'phpdoc'
        ]
    );

};
