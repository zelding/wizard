const gulp      = require('gulp');
const concat    = require('gulp-concat');
const uglify    = require('gulp-uglify');
const uglifyCss = require('gulp-uglifycss');

gulp.task('watch', ['build'], () => {
    gulp.watch('assets/css/**/*.*', ['build']);
    gulp.watch('assets/js/**/*.*', ['build']);
});

gulp.task('css', () => {
    return gulp.src([
        "assets/css/*.css",
        "assets/css/**/*.*"
    ]).pipe(uglifyCss())
        .pipe(concat('style.css'))
        .pipe(gulp.dest('public/css/'));
});

gulp.task('js', () => {
    return gulp.src([
        "assets/js/*.js",
        "assets/js/**/*.js"
    ]).pipe(uglify())
      .pipe(concat('script.js'))
      .pipe(gulp.dest('public/js/'));
});

gulp.task('vendor-js', () => {
    return gulp.src([
        "node_modules/jquery/dist/jquery.min.js",
        "node_modules/tether/dist/js/tether.min.js",
        "node_modules/bootstrap/dist/js/bootstrap.min.js"
    ]).pipe(concat('vendor.js')).pipe(gulp.dest('public/js/'));
});

gulp.task('vendor-css', () => {
    return gulp.src([
        "node_modules/bootstrap/dist/css/bootstrap.min.css",
        "node_modules/tether/dist/css/tether.min.css",
    ]).pipe(concat('vendor.css')).pipe(gulp.dest('public/css/'));
});

gulp.task('build', ['css', 'js']);

gulp.task('vendor', ['vendor-css', 'vendor-js']);

gulp.task('default', ['build']);

gulp.task('all', ['vendor', 'build']);
