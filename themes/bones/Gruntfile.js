/*global module:false*/
module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    // Metadata.
    dirs: {
      jsSrc: 'library/js/src',
      jsTmp: 'library/js/tmp',
      jsBuild: 'library/js/build',
      jsDist: 'library/js/dist',

      sassSrc: 'library/scss',
      cssSrc: 'library/css'
    },
    pkg: grunt.file.readJSON('package.json'),
    banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - ' +
      '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
      '<%= pkg.homepage ? "* " + pkg.homepage + "\\n" : "" %>' +
      '* Copyright (c) <%= grunt.template.today("yyyy") %>;' +
      ' Licensed <%= _.pluck(pkg.licenses, "type").join(", ") %> */\n',
    // Task configuration.
    clean: {
      css: [
        'library/js/tmp',
        'library/js/build',
        'library/js/dist'
      ],
      js: [
        'library/js/tmp',
        'library/js/build',
        'library/js/dist'
      ],
      tmp: [
        'library/js/tmp',
      ]
    },
    concat: {
      options: {},
      build: {
        src: [
          '<%= dirs.jsSrc %>/libs/jquery.bxslider.min.js',
          '<%= dirs.jsSrc %>/modules/video.js',
          '<%= dirs.jsSrc %>/main.js'
        ],
        dest: '<%= dirs.jsBuild %>/scripts.js'
      },
      dist: {
        src: [
          '<%= dirs.jsSrc %>/libs/jquery.bxslider.min.js',
          '<%= dirs.jsTmp %>/min/js/video.js',
          '<%= dirs.jsTmp %>/min/js/main.js'
        ],
        dest: '<%= dirs.jsDist %>/scripts.min.js'
      },
    },
    uglify: {
      options: {
        preserveComments: 'some'
      },
      main: {
        files: [{
          expand: true,
          cwd: 'library/js/src',
          src: ['**/*.js', '!modules/*.js', '!libs/*.js'],
          dest: 'library/js/tmp/min/js'
        }]
      },
      modules: {
        files: [{
          expand: true,
          cwd: 'library/js/src/modules',
          src: ['**/*.js'],
          dest: 'library/js/tmp/min/js'
        }]
      }
    },
    jshint: {
      options: {
        curly: true,
        eqeqeq: true,
        immed: true,
        latedef: true,
        newcap: true,
        noarg: true,
        sub: true,
        undef: true,
        unused: true,
        boss: true,
        eqnull: true,
        globals: {}
      },
      gruntfile: {
        src: 'Gruntfile.js'
      },
      site_js: {
        src: ['lib/**/*.js', 'test/**/*.js']
      }
    },
    sass: {                              // Task
      options: {                       // Target options
        style: 'expanded'
      },
      admin: {                            // Target
        files: {                         // Dictionary of files
          '<%= dirs.cssSrc %>/admin.css': '<%= dirs.sassSrc %>/admin.scss',
        }
      },
      login: {                            // Target
        files: {                         // Dictionary of files
          '<%= dirs.cssSrc %>/login.css': '<%= dirs.sassSrc %>/login.scss',
        }
      },
      main: {                            // Target
        files: {                         // Dictionary of files
          '<%= dirs.cssSrc %>/style.css': '<%= dirs.sassSrc %>/style.scss',
        }
      }
    },
    watch: {
      gruntfile: {
        files: '<%= jshint.gruntfile %>',
        tasks: ['jshint:gruntfile']
      },
      sassAdmin: {
        files: '<%= dirs.sassSrc %>/admin.scss',
        tasks: ['sassAdmin']
      },
      sassLogin: {
        files: '<%= dirs.sassSrc %>/login.scss',
        tasks: ['sassLogin']
      },
      sassMain: {
        files: '<%= dirs.sassSrc %>/style.scss',
        tasks: ['sassMain']
      }
    }
  });

  // These plugins provide necessary tasks.
  require('load-grunt-tasks')(grunt);

  // Default task.
  grunt.registerTask('dev', ['watch']);

  // build and concat main js and modules
  grunt.registerTask('jsBuild', ['clean:js', 'uglify', 'concat:build', 'concat:dist', 'clean:tmp']);

  // sass builds
  grunt.registerTask('sassAdmin', ['sass:admin']);
  grunt.registerTask('sassLogin', ['sass:login']);
  grunt.registerTask('sassMain', ['sass:main']);

  // grunt.registerTask('tmp', ['clean:all', 'uglify', 'concat:build']);

};
