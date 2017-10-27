var gulp                = require("gulp"),
    plumber             = require('gulp-plumber'),
    notify              = require('gulp-notify'),
    del                 = require('del'),
    runSequence         = require('run-sequence'),
    cache               = require('gulp-cache');


var dirs = {
    src: './src/',
    dist: './',
    build: './build/'
};


/**
 * PHPMailer source files
 */
gulp.task('vendor-phpmailer', function () {
    var src = gulp.src( dirs.src + 'vendor/phpmailer/src/*.php' )
        .pipe( plumber({ errorHandler: function(err) {
            notify.onError({
                title: "Gulp error in " + err.plugin,
                message:  err.toString()
            })(err);
        }}) )
        .pipe( gulp.dest(dirs.dist + 'lib/phpmailer/src') );

    var lang = gulp.src( dirs.src + 'vendor/phpmailer/language/*.php' )
        .pipe( plumber({ errorHandler: function(err) {
            notify.onError({
                title: "Gulp error in " + err.plugin,
                message:  err.toString()
            })(err);
        }}) )
        .pipe( gulp.dest(dirs.dist + 'lib/phpmailer/language') );

    return src && lang;
});


/**
 * Copying files from the vendor libraries
 */
gulp.task('vendor-php', function () {
    return runSequence('vendor-phpmailer');
});


/**
 * Cache clear
 */
gulp.task('clear', function (done) {
    return cache.clearAll(done);
});