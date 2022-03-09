var gulp = require("gulp"),
	sass = require("gulp-sass"),
    rename = require("gulp-rename"),
    sourcemaps = require("gulp-sourcemaps"),
    notify = require("gulp-notify"),
	wpPot = require('gulp-wp-pot'),
	clean = require("gulp-clean"),
    plumber = require("gulp-plumber");

var tasks = {
    backendExpended: {src: "assets/scss/backend-main.scss", mode: 'expanded', destination: 'admin_notice.css'},
    backendCompressed: {src: "assets/scss/backend-main.scss", mode: 'compressed', destination: 'admin_notice.min.css'},
    frontendExpanded: {src: "assets/scss/frontend-main.scss", mode: 'expanded', destination: 'tutor-divi-style.css'},
    frontendCompressed: {src: "assets/scss/frontend-main.scss", mode: 'compressed', destination: 'tutor-divi-style.min.css'},
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


/*
 * series for doing multiple task in order 1->2->3
 * src is for getting files from the computer
 * dest is for transfer file to destination 
*/
const { series, src, dest } = require('gulp');
//install plugins
const uglify	= require('gulp-uglify');

const zip = require('gulp-zip');

const babel		= require('gulp-babel');

const package = require('./package.json'); 

// minify all js
function minifyJs(cb) {
	return src('assets/js/*.js')
	.pipe(babel())
	.pipe(uglify())
	.pipe(rename('scripts.min.js'))
	.pipe(dest('assets/js/'));

	cb();
}


//clean existing build zip file
function cleanZip(cb) {
	return gulp.src("./*.zip", {
		read: false,
		allowEmpty: true
	}).pipe(clean());
	cb();
}


//clean file & folders from build

function cleanBuild(cb) {
	return gulp.src("./build", {
		read: false,
		allowEmpty: true
	}).pipe(clean());
	cb();
};

//create pot file
function makePot(cb) {
	return gulp
		.src('**/*.php')
		.pipe(plumber({
			errorHandler: onError
		}))
		.pipe(wpPot({
			domain: 'tutor-lms-divi-modules',
			package: 'Tutor Divi Modules'
		}))
		.pipe(gulp.dest('languages/tutor-lms-divi-modules.pot'));
		cb();
};
// bundle all files export to destination directory
function bundleFiles(cb){
	return src([
		"./**/*.*",
		"!./build/**",
		"!./assets/scss/**",
		"!./media/**",
		"!./node_modules/**",
		"!./**/*.zip",
		"!.github",
		"!./gulpfile.js",
		"!./readme.md",
		"!./README.md",
		"!.DS_Store",
		"!./**/.DS_Store",
		"!./LICENSE.txt",
		"!./package.json",
		"!./asset-manifest.json",
		"!./package-lock.json",
		"!./includes/modules/**/*.jsx",
	])
	.pipe(dest("build/"));
	cb();
}


// from destination directory take all files make zip
function exportZip(cb) {
	const buildName = `tutor-lms-divi-modules.zip`;
	return src("./build/**/*.*").pipe(zip(buildName)).pipe(dest("./"));
	cb();
}


gulp.task("watch", function () {
	gulp.watch("assets/scss/**/*.scss", gulp.series(...task_keys));
});

exports.default 	= series(...task_keys, "watch");
exports.build 		= series(...task_keys, cleanZip,cleanBuild,makePot,bundleFiles, exportZip);
