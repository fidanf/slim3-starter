var gulp = require('gulp');
var sass = require('gulp-sass');
var nano = require('gulp-cssnano');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var autoprefixer = require('gulp-autoprefixer');
var apidoc = require('gulp-apidoc');

var scripts = [
	"bower_components/jquery/dist/jquery.js",
	"bower_components/bootstrap/dist/js/bootstrap.js",
	"bower_components/bootstrap/dist/js/alert.js",
	"resources/assets/scripts/app.js"
];

gulp.task('scripts', function () {
	return gulp.src(scripts)
	.pipe(concat('app.js'))
	.pipe(uglify())
	.pipe(gulp.dest('./public/js'))
});

gulp.task('styles', function () {
return gulp.src([
	'bower_components/bootstrap/dist/css/bootstrap.css',
	'resources/assets/styles/app.scss'
	])
	.pipe(sass())
	.pipe(nano())
	.pipe(concat('app.css'))
	.pipe(gulp.dest('./public/css'))
});

gulp.task('apidoc', function(done){
    apidoc({
        src: "./",
        dest: "doc/",
        // debug: true,
        includeFilters: [ ".*\\.php$" ]
    }, done);
});

gulp.task('watch-build', function () {
	// /**/**/*.ext pour inclure les éventuels subdir
	gulp.watch('resources/assets/styles/**/**/*.scss', ['styles']);
	gulp.watch('resources/assets/scripts/**/**/*.js', ['scripts']);
	gulp.watch('app/Controllers/**/**/*.php', ['apidoc']);
});

gulp.task('default', ['styles', 'scripts']);

gulp.task('watch', ['default', 'watch-build']);