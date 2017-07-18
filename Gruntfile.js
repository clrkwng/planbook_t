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
        copy: {
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
