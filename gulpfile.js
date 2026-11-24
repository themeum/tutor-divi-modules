const gulp = require("gulp");
const { series, src, dest } = require("gulp");
const notify = require("gulp-notify");
const wpPot = require("gulp-wp-pot");
const clean = require("gulp-clean");
const plumber = require("gulp-plumber");
const zip = require("gulp-zip");

const onError = function (err) {
	notify.onError({
		title: "Gulp",
		subtitle: "Failure!",
		message: "Error: <%= error.message %>",
		sound: "Basso",
	})(err);
	this.emit("end");
};

function cleanZip(cb) {
	return gulp.src("./*.zip", {
		read: false,
		allowEmpty: true,
	}).pipe(clean());
}

function cleanBuild(cb) {
	return gulp.src("./build", {
		read: false,
		allowEmpty: true,
	}).pipe(clean());
}

function makePot() {
	return gulp
		.src("**/*.php")
		.pipe(plumber({
			errorHandler: onError,
		}))
		.pipe(wpPot({
			domain: "tutor-lms-divi-modules",
			package: "Tutor Divi Modules",
		}))
		.pipe(gulp.dest("languages/tutor-lms-divi-modules.pot"));
}

function bundleFiles() {
	return src([
		"./**/*.*",
		"!./build/**",
		"!./assets/scss/**",
		"!./node_modules/**",
		"!./**/*.zip",
		"!.github",
		"!./gulpfile.js",
		"!./webpack.config.js",
		"!./readme.md",
		"!./README.md",
		"!.DS_Store",
		"!./**/.DS_Store",
		"!./LICENSE.txt",
		"!./package.json",
		"!./asset-manifest.json",
		"!./package-lock.json",
		"!.npmrc",
		"!./includes/modules/**/*.jsx",
		"!./includes/div5modules/**/*.jsx",
		"!./**/*.map",
	])
		.pipe(dest("build/tutor-lms-divi-modules"));
}

function exportZip() {
	const pkg = require("./package.json");
	const buildName = `tutor-lms-divi-modules-${pkg.version}.zip`;
	return src("./build/**/*.*").pipe(zip(buildName)).pipe(dest("./"));
}

exports.build = series(cleanZip, cleanBuild, makePot, bundleFiles, exportZip);
