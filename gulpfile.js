var gulp = require('gulp');
var sass = require('gulp-sass');
var browserSync = require('browser-sync').create();
var reload      = browserSync.reload;

//gulp sass
gulp.task('sass', function(){
  return gulp.src('app/scss/*.scss')
    .pipe(sass())
    .pipe(gulp.dest('app/css'))
});

gulp.task('serve', function () {

    // Serve files from the root of this project
    browserSync.init({
        server: {
            baseDir: "./app"
        }
    });

    gulp.watch("./app/*.html").on("change", reload);
    gulp.watch("./app/js/*.js").on("change", reload);
    gulp.watch("./app/scss/*.scss").on("change", gulp.series('sass', reload));
});