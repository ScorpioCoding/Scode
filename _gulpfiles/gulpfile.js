const { src, dest, watch, series } = require("gulp");
const sass = require("gulp-sass")(require("sass"));
const postcss = require("gulp-postcss");
const cssNano = require("cssnano");
const terser = require("gulp-terser");
const rename = require("gulp-rename");

//Templates
function copyApp() {
  return src("../dev/App/**/*.phtml").pipe(dest("../html/App/"));
}

//Views
function copyPhtml() {
  return src("../dev/Modules/**/*.phtml").pipe(dest("../html/Modules/"));
}

//Controllers, Models, Utils
function copyPhp() {
  return src("../dev/Modules/**/*.php").pipe(dest("../html/Modules/"));
}

//Translation
function copyJson() {
  return src("../dev/**/*.json").pipe(dest("../html/"));
}

function copyImages() {
  return src("../dev/public/**/*.{gif,png,jpg,jpeg,svg}")
    .pipe(
      rename(function (path) {
        path.dirname = path.dirname.toLowerCase();
        path.basename = path.basename.toLowerCase();
        path.extname = path.extname.toLowerCase();
      })
    )
    .pipe(dest("../html/public/"));
}

function scssTask() {
  return src("../dev/public/**/*.scss")
    .pipe(sass())
    .pipe(postcss([cssNano()]))
    .pipe(
      rename(function (path) {
        path.dirname = path.dirname.toLowerCase();
        path.basename = path.basename.toLowerCase();
        path.extname = path.extname.toLowerCase();
      })
    )
    .pipe(dest("../html/public/"));
}

function jsTask() {
  return src("../dev/public/**/*.js")
    .pipe(terser())
    .pipe(
      rename(function (path) {
        path.dirname = path.dirname.toLowerCase();
        path.basename = path.basename.toLowerCase();
        path.extname = path.extname.toLowerCase();
      })
    )
    .pipe(dest("../html/public/"));
}

function watchTask() {
  watch("../dev/App/**/*.phtml", copyApp);
  watch("../dev/Modules/**/*.phtml", copyPhtml);
  watch("../dev/Modules/**/*.php", copyPhp);
  watch("../dev/Modules/**/*.json", copyJson);
  watch("../dev/public/**/*.{gif,png,jpg,jpeg,svg}", copyImages);
  watch("../dev/public/**/*.scss", scssTask);
  watch("../dev/public/**/*.js", jsTask);
}

exports.default = series(
  copyApp,
  copyPhtml,
  copyPhp,
  copyJson,
  copyImages,
  scssTask,
  jsTask,
  watchTask
);
