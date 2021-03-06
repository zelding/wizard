const gulp      = require('gulp');
const concat    = require('gulp-concat');
const uglify    = require('gulp-uglify');
const uglifyCss = require('gulp-uglifycss');

gulp.task('watch', ['build'], f => {
    gulp.watch('src/AppBundle/Resources/css/**/*.*', ['build']);
    gulp.watch('src/AppBundle/Resources/js/**/*.*', ['build']);
});

gulp.task('css', f => {
    return gulp.src([
        "src/AppBundle/Resources/public/css/*.css",
        "src/AppBundle/Resources/public/css/**/*.*"
    ]).pipe(uglifyCss())
        .pipe(concat('style.css'))
        .pipe(gulp.dest('web/css/'));
});

gulp.task('js', f => {
    return gulp.src([
        "src/AppBundle/Resources/public/js/*.js",
        "src/AppBundle/Resources/public/js/**/*.js"
    ]).pipe(uglify())
      .pipe(concat('script.js'))
      .pipe(gulp.dest('web/js/'));
});

gulp.task('vendor-js', f => {
    return gulp.src([
        "node_modules/jquery/dist/jquery.min.js",
        "node_modules/tether/dist/js/tether.min.js",
        "node_modules/bootstrap/dist/js/bootstrap.min.js"
    ]).pipe(concat('vendor.js')).pipe(gulp.dest('web/js/'));
});

gulp.task('vendor-css', f => {
    return gulp.src([
        "node_modules/bootstrap/dist/css/bootstrap.min.css",
        "node_modules/tether/dist/css/tether.min.css",
    ]).pipe(concat('vendor.css')).pipe(gulp.dest('web/css/'));
});

gulp.task('build', ['css', 'js']);

gulp.task('vendor', ['vendor-css', 'vendor-js']);

gulp.task('default', ['build']);

gulp.task('all', ['build', 'vendor']);
