var gulp = require("gulp"),
	sass = require("gulp-sass"),
    rename = require("gulp-rename"),
    sourcemaps = require("gulp-sourcemaps"),
    plumber = require("gulp-plumber");

var tasks = {
    tutor_divi: {src: "assets/scss/main.scss", mode: 'expanded', destination: 'tutor-divi-style.css'},
    tutor_divi_min: {src: "assets/scss/main.scss", mode: 'compressed', destination: 'tutor-divi-style.min.css'},
};

var task_keys = Object.keys(tasks);

var onError = function (err) {
	notify.onError({
		title: "Gulp",
		subtitle: "Failure!",
		message: "Error: <%= error.message %>",
		sound: "Basso",
	})(err);
	this.emit("end");
};

for(let task in tasks) {

    let blueprint = tasks[task];
    
    gulp.task(task, function () {
        return gulp
			.src(blueprint.src)
			.pipe(plumber({
				errorHandler: onError
			}))
			.pipe(sass({
				outputStyle: blueprint.mode
			}))
			.pipe(rename(blueprint.destination))
			.pipe(sourcemaps.write("."))
			.pipe(gulp.dest("assets/css"));        
    });
}

gulp.task("watch", function () {
	gulp.watch("assets/scss/**/*.scss", gulp.series(...task_keys));
});
