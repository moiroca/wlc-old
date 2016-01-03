/* File: gulpfile.js */

// grab our gulp packages
var gulp  = require('gulp');

	// create a default task and just log a message
	gulp.task('default', function() {
		return gulp.src('node_modules/**/*.js')
				   .pipe(gulp.dest('public/js/vendor/'));
	});
