module.exports = function (grunt) {

    var xamppDir = "C:/Users/andrew.parise/Projects/3rdParty/xampp";

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        resourcesPath: 'planbook/src/AppBundle/Resources',
        adminResourcesPath: 'planbook/src/AdminBundle/Resources',
        appBundlePath: 'planbook/src/AppBundle',
        appConfigPath: 'planbook/app/confg',
        appResourcesPath: 'planbook/app/Resources',

        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            build: {
                src: 'planbook/src/<%= pkg.name %>.js',
                dest: 'planbook/<%= pkg.name %>.min.js'
            }
        },

        shell: {
            cache_clear_prod: {
                options: {
                    stdout: true
                },
                command: 'php planbook/bin/console cache:clear --env=prod --no-debug'
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
            js_app: ['planbook/web/js/app/*'],
            img_app: ['planbook/web/img/*'],
            js_app_build: ['planbook/web/js-app-build'],
            js_admin: ['planbook/web/js/admin/*'],
            js_admin_build: ['planbook/web/js-admin-build'],
            css_app: ['planbook/web/css/app/*'],
            css_admin: ['planbook/web/css/admin/*'],
            xampp: [
                xamppDir + '/htdocs/planbook/*'
            ],
            deploy_appBundle_admin: [
                xamppDir + '/htdocs/planbook/src/AppBundle/Admin/*'
            ],
            deploy_app_config: [
                xamppDir + '/htdocs/planbook/app/config/*'
            ],
            deploy_app_resources: [
                xamppDir + '/htdocs/planbook/app/Resources/*'
            ],
            deploy_appBundle_controller: [
                xamppDir + '/htdocs/planbook/src/AppBundle/Controller/*'
            ],
            deploy_appBundle_dependencyInjection: [
                xamppDir + '/htdocs/planbook/src/AppBundle/DependencyInjection/*'
            ],
            deploy_appBundle_entity: [
                xamppDir + '/htdocs/planbook/src/AppBundle/Entity/*'
            ],
            deploy_appBundle_eventListener: [
                xamppDir + '/htdocs/planbook/src/AppBundle/EventListener/*'
            ],
            deploy_appBundle_form: [
                xamppDir + '/htdocs/planbook/src/AppBundle/Form/*'
            ],
            deploy_appBundle_menu: [
                xamppDir + '/htdocs/planbook/src/AppBundle/Menu/*'
            ],
            deploy_appBundle_repository: [
                xamppDir + '/htdocs/planbook/src/AppBundle/Repository/*'
            ],
            deploy_appBundle_service: [
                xamppDir + '/htdocs/planbook/src/AppBundle/Service/*'
            ],
            deploy_appBundle_util: [
                xamppDir + '/htdocs/planbook/src/AppBundle/Util/*'
            ]

        },
        less: {
            app: {
                options: {
                    paths: ['<%= resourcesPath %>/public/less'],
                    compress: true
                },
                files: {
                    'planbook/web/css/app/style.min.css': '<%= resourcesPath %>/public/less/style.less'
                }
            },
            admin: {
                options: {
                    paths: ['<%= adminResourcesPath %>/public/less'],
                    compress: true
                },
                files: {
                    'planbook/web/css/admin/style.min.css': '<%= adminResourcesPath %>/public/less/style.less'
                }
            }
        },
        copy: {
            js_app: {
                expand: true,
                cwd: '<%= resourcesPath %>/public/js/',
                src: '**',
                dest: 'planbook/web/js/app'
            },
            js_app_build: {
                expand: true,
                cwd: 'web/js-app-build/',
                src: '**',
                dest: 'planbook/web/js/app'
            },
            js_admin: {
                expand: true,
                cwd: '<%= adminResourcesPath %>/public/js/',
                src: '**',
                dest: 'planbook/web/js/admin'
            },
            js_admin_build: {
                expand: true,
                cwd: 'web/js-admin-build/',
                src: '**',
                dest: 'planbook/web/js/admin'
            },
            img_app: {
                expand: true,
                cwd: '<%= resourcesPath %>/public/img/',
                src: '**',
                dest: 'planbook/web/img'
            },
            app_resources: {
                expand: true,
                cwd: '<%= appResourcesPath %>/public/img/',
                src: '**',
                dest: 'planbook/web/img'
            },
            appBundle_controller: {
                expand: true,
                cwd: '<%= appBundlePath %>/Controller/',
                src: '**',
                dest: xamppDir + '/htdocs/planbook/src/AppBundle/Controller'
            },
            appBundle_admin: {
                expand: true,
                cwd: '<%= appBundlePath %>/Admin/',
                src: '**',
                dest: xamppDir + '/htdocs/planbook/src/AppBundle/Admin'
            },
            app_config: {
                expand: true,
                cwd: '<%= appConfigPath %>/config/',
                src: '**',
                dest: xamppDir + '/htdocs/planbook/app/config'
            },
            appBundle_dependencyInjection: {
                expand: true,
                cwd: '<%= appBundlePath %>/DependencyInjection/',
                src: '**',
                dest: xamppDir + '/htdocs/planbook/src/AppBundle/DependencyInjection'
            },
            appBundle_entity: {
                expand: true,
                cwd: '<%= appBundlePath %>/Entity/',
                src: '**',
                dest: xamppDir + '/htdocs/planbook/src/AppBundle/Entity'
            },
            appBundle_eventListener: {
                expand: true,
                cwd: '<%= appBundlePath %>/EventListener/',
                src: '**',
                dest: xamppDir + '/htdocs/planbook/src/AppBundle/EventListener'
            },
            appBundle_form: {
                expand: true,
                cwd: '<%= appBundlePath %>/Form/',
                src: '**',
                dest: xamppDir + '/htdocs/planbook/src/AppBundle/Form'
            },
            appBundle_menu: {
                expand: true,
                cwd: '<%= appBundlePath %>/Menu/',
                src: '**',
                dest: xamppDir + '/htdocs/planbook/src/AppBundle/Menu'
            },
            appBundle_repository: {
                expand: true,
                cwd: '<%= appBundlePath %>/Repository/',
                src: '**',
                dest: xamppDir + '/htdocs/planbook/src/AppBundle/Repository'
            },
            appBundle_service: {
                expand: true,
                cwd: '<%= appBundlePath %>/Service/',
                src: '**',
                dest: xamppDir + '/htdocs/planbook/src/AppBundle/Service'
            },
            appBundle_util: {
                expand: true,
                cwd: '<%= appBundlePath %>/Util/',
                src: '**',
                dest: xamppDir + '/htdocs/planbook/src/AppBundle/Util'
            },
            xampp: {
                files: [
                   {
                       expand: true,
                       cwd: 'planbook/',
                       src: ['**'],
                       dest: xamppDir + '/htdocs/planbook/'
                   }
               ]
            }
        },

        requirejs: {
            compile_app: {
                options: {
                    mainConfigFile: 'planbook/web/js/app/main.js',
                    baseUrl: './',
                    appDir: 'planbook/web/js/app',
                    dir: 'planbook/web/js-app-build',
                    removeCombined: true,
                    findNestedDependencies: true,
                    modules: [
                        { name: 'main' },
                        { name: 'pages/home', exclude: ['main'] },
                        { name: 'pages/orderCheckout', exclude: ['main'] },
                        { name: 'pages/productDetail', exclude: ['main'] }
                    ],
                    done: function(done, output) {
                        grunt.file.delete('planbook/web/js-app-build/build.txt', { force: true});
                        done();
                    }
                }
            },
            compile_admin: {
                options: {
                    mainConfigFile: 'planbook/web/js/admin/main.js',
                    baseUrl: './',
                    appDir: 'planbook/web/js/admin',
                    dir: 'planbook/web/js-admin-build',
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
                        grunt.file.delete('planbook/web/js-admin-build/build.txt', { force: true});
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
                files: 'planbook/web/css/**/*.css',
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
            },
            app_config: {
                files: '<%= appConfigPath %>/*',
                tasks: ['clean:deploy_app_config', 'copy:app_config'],
                options: {
                    livereload: true
                }
            },
            app_resources: {
                files: '<%= appResourcesPath %>/*',
                tasks: ['clean:deploy_app_resources', 'copy:app_resources'],
                options: {
                    livereload: true
                }
            },
            appBundle_admin: {
                files: '<%= appBundlePath %>/Admin/*',
                tasks: ['clean:deploy_appBundle_admin', 'copy:appBundle_admin'],
                options: {
                    livereload: true
                }
            },
            appBundle_controller: {
                files: '<%= appBundlePath %>/Controller/*',
                tasks: ['clean:deploy_appBundle_controller', 'copy:appBundle_controller'],
                options: {
                    livereload: true
                }
            },
            appBundle_dependencyInjection: {
                files: '<%= appBundlePath %>/DependencyInjection/*',
                tasks: ['clean:deploy_appBundle_dependencyInjection', 'copy:appBundle_dependencyInjection'],
                options: {
                    livereload: true
                }
            },
            appBundle_entity: {
                files: '<%= appBundlePath %>/Entity/*',
                tasks: ['clean:deploy_appBundle_entity', 'copy:appBundle_entity'],
                options: {
                    livereload: true
                }
            },
            appBundle_eventListener: {
                files: '<%= appBundlePath %>/EventListener/*',
                tasks: ['clean:deploy_appBundle_eventListener', 'copy:appBundle_eventListener'],
                options: {
                    livereload: true
                }
            },
            appBundle_form: {
                files: '<%= appBundlePath %>/Form/*',
                tasks: ['clean:deploy_appBundle_form', 'copy:appBundle_form'],
                options: {
                    livereload: true
                }
            },
            appBundle_menu: {
                files: '<%= appBundlePath %>/Menu/*',
                tasks: ['clean:deploy_appBundle_menu', 'copy:appBundle_menu'],
                options: {
                    livereload: true
                }
            },
            appBundle_repository: {
                files: '<%= appBundlePath %>/Repository/*',
                tasks: ['clean:deploy_appBundle_repository', 'copy:appBundle_repository'],
                options: {
                    livereload: true
                }
            },
            appBundle_service: {
                files: '<%= appBundlePath %>/Service/*',
                tasks: ['clean:deploy_appBundle_service', 'copy:appBundle_service'],
                options: {
                    livereload: true
                }
            },
            appBundle_util: {
                files: '<%= appBundlePath %>/Util/*',
                tasks: ['clean:deploy_appBundle_util', 'copy:appBundle_util'],
                options: {
                    livereload: true
                }
            }
        },
        phpdoc: {
            options: {
                verbose: true
            },
            src: [
                'planbook/src/AppBundle/'
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

    grunt.registerTask('dev', ['default', 'xampp-deploy']);

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
