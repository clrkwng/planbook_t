module.exports = function (grunt) {

    var isApple = false; //This flag needs to be set based on the dev environment's base OS
    var target;
    if(isApple){
        target = grunt.option('target') || 'devApple';
    }else{
        target = grunt.option('target') || 'devWindows'
    }

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
            options: { force: true },

            bin: [
                'bin/*'
            ],
            devWindows: [
                'C:/xampp/htdocs/planbook/*'
            ],
            devApple: [
                //insert Apple unique paths to clean here
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
                    "bin/css/admin/admin.css": "web/less/admin/*.less",
                    "bin/css/auth/account-verification.css": "web/less/auth/account-verification/*.less",
                    "bin/css/auth/create-account.css": "web/less/auth/create-account/*.less",
                    "bin/css/auth/login.css": "web/less/auth/login/*.less",
                    "bin/css/email-sender/email-sender.css": "web/less/email-sender/*.less",
                    "bin/css/error/error.css": "web/less/error/*.less",
                    "bin/css/user/homepage.css": "web/less/user/homepage.less",
                    "bin/css/user/market.css": "web/less/user/market.less",
                    "bin/css/user/user-profile.css": "web/less/user/user-profile.less"
                }
            }
        },
        properties: {
            devWindows: [
                'application/config/profiles/dev/base.properties',
                'application/config/profiles/dev/windows.properties'
            ],
            devApple: [
                'application/config/profiles/dev/base.properties',
                'application/config/profiles/dev/apple.properties'
            ]
        },
        copy: {
            bin: {
                files: [
                    {
                        expand: true,
                        cwd: 'web/css',
                        src: ['**'],
                        dest: 'bin/css/'
                    },
                    {
                        expand: true,
                        cwd: 'web/img',
                        src: ['**'],
                        dest: 'bin/resources/img/'
                    },
                    {
                        expand: true,
                        cwd: 'web/js',
                        src: ['**'],
                        dest: 'bin/scripts/'
                    },
                    {
                        expand: true,
                        cwd: 'src/AppBundle/views',
                        src: [
                            '**'
                        ],
                        dest: 'bin/modules/'
                    },
                    {
                        expand: true,
                        cwd: 'node_modules/font-awesome',
                        src: ['**'],
                        dest: 'bin/libs/font-awesome/'
                    },
                    {
                        expand: true,
                        cwd: 'node_modules/jquery',
                        src: ['**'],
                        dest: 'bin/libs/jquery/'
                    },
                    {
                        expand: true,
                        cwd: 'node_modules/freelancer',
                        src: ['**'],
                        dest: 'bin/libs/freelancer/'
                    },
                    {
                        expand: true,
                        cwd: 'node_modules/bootstrap',
                        src: ['**'],
                        dest: 'bin/libs/bootstrap/'
                    },
                    {
                        expand: true,
                        cwd: 'node_modules/fullpage.js',
                        src: ['**'],
                        dest: 'bin/libs/fullpage-js/'
                    },
                    {
                        expand: true,
                        cwd: 'node_modules/html5shiv',
                        src: ['**'],
                        dest: 'bin/libs/html5shiv/'
                    },
                    {
                        expand: true,
                        cwd: 'node_modules/jquery.easing',
                        src: ['**'],
                        dest: 'bin/libs/jquery-easing/'
                    },
                    {
                        expand: true,
                        cwd: 'node_modules/jquery-backstretch',
                        src: ['**'],
                        dest: 'bin/libs/jquery-backstretch/'
                    },
                    {
                        expand: true,
                        cwd: 'node_modules/jquery-ui',
                        src: ['**'],
                        dest: 'bin/libs/jquery-ui/'
                    },
                    {
                        expand: true,
                        cwd: 'node_modules/w3-css',
                        src: ['**'],
                        dest: 'bin/libs/w3-css/'
                    },
                    {
                        expand: true,
                        cwd: 'vendor',
                        src: ['**'],
                        dest: 'bin/libs/vendor/'
                    }

                ]
            },
            devWindows: {

                files: [
                   {
                       expand: true,
                       cwd: 'bin',
                       src: ['**'],
                       dest: 'C:/xampp/htdocs/planbook/'
                   }
               ]
            },
            devApple: {

                // files: [
                //     {
                //         expand: true,
                //         cwd: 'bin',
                //         src: ['**'],
                //         dest: ''
                //     }
                // ]
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
                            replacement: '<%= '+ target +'.dbHost %>'
                        },
                        {
                            pattern: '{db.name}',
                            replacement: '<%= '+ target +'.dbName %>'
                        },
                        {
                            pattern: '{db.user}',
                            replacement: '<%= '+ target +'.dbUser %>'
                        },
                        {
                            pattern: '{db.password}',
                            replacement: '<%= '+ target +'.dbPassword %>'
                        }
                    ]
                }
            }
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


    //Build Task Registration
    grunt.registerTask('default',
        [
            'buildToBin',
            'deploy'
        ]
    );

    grunt.registerTask('buildToBin',
        [
            'properties',
            'clean:bin',
            'copy:bin',
            'less:bin',
            'string-replace:bin'

        ]
    );
    grunt.registerTask('deploy',
        [
            'clean:' + target,
            'copy:' + target
        ]
    );

};
