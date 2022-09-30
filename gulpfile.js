const { series, parallel, src, dest } = require('gulp');
const concat    = require('gulp-concat');
const uglify    = require('gulp-uglify');
const uglifyCss = require('gulp-uglifycss');

function customCss() {
    return src([
        "assets/css/*.css",
        "assets/css/**/*.*"
    ]).pipe(uglifyCss())
      .pipe(concat('style.css'))
      .pipe(dest('public/css/'));
}

function customJs() {
    return src([
        "assets/js/*.js",
        "assets/js/**/*.js"
    ]).pipe(uglify())
      .pipe(concat('script.js'))
      .pipe(dest('public/js/'));
}

function vendorJs() {
    return src([
        "node_modules/jquery/dist/jquery.min.js",
        "node_modules/tether/dist/js/tether.min.js",
        "node_modules/bootstrap/dist/js/bootstrap.min.js"
    ]).pipe(concat('vendor.js'))
      .pipe(dest('public/js/'));
}

function vendorCss() {
    return src([
        "node_modules/bootstrap/dist/css/bootstrap.min.css",
        "node_modules/tether/dist/css/tether.min.css",
    ]).pipe(concat('vendor.css'))
      .pipe(dest('public/css/'));
}

function build(js, css) {
    return parallel(js, css);
}

exports.default = build(customJs, customCss)
exports.vendor  = build(vendorJs, vendorCss)
exports.all     = series(build(customJs, customCss), build(vendorJs, vendorCss))
