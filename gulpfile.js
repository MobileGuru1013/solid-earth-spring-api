var gulp = require('gulp')
  , coffee = require('gulp-coffee')
  , concat = require('gulp-concat');

var paths = {
  vendor: [
    './bower_components/jquery/dist/jquery.js',
    './bower_components/mustache/mustache.js',
    './bower_components/handlebars/handlebars.js',
    './bower_components/unslider/src/unslider.js',
    './js/api-client.js'
  ],

  plugin: ['./coffee/plugin.coffee'],
  client: ['./coffee/api-client.coffee']
};

gulp.task('plugin', function () {
  gulp.src(paths.plugin)
  .pipe(coffee())
  .pipe(gulp.dest('./js'));
});

gulp.task('client', function () {
  gulp.src(paths.client)
  .pipe(coffee({bare: true}))
  .pipe(gulp.dest('./js'));
});

gulp.task('vendor', ['client'], function () {
  gulp.src(paths.vendor)
  .pipe(concat('vendor.js'))
  .pipe(gulp.dest('./js'));
});

gulp.task('watch', function () {
  gulp.watch(paths.plugin, ['plugin']);
  gulp.watch(paths.client, ['client']);
  gulp.watch(paths.client, ['vendor']);
});

gulp.task('default', ['plugin', 'client', 'vendor', 'watch']);