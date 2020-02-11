/**
 * - - - - - - - - - - EDIT YOUR PATHS
 * - - - - - - - - - - - - - - - - - -
 */
const paths = {
        styles: {
            watch   : 'src/scss/**/*.scss',
            dest    : '../assets/css/'
        },
        scripts: {
            watch   : 'src/js/**/*.js',
            dest    : '../assets/js/'
        },
        pages: {
            watch   : 'src/pages/**/**/*.njk',  // files to watch (include all partials)
            compile : 'src/pages/templates',    // template used to compile with
            render  : 'src/pages/*njk',         // pages to render (don't render partials)
            dest    : 'dist/'
        },
        images: {
            watch   : 'src/img/**/*',
            dest    : '../assets/img/'
        },
        data: {
            src     : 'src/data/data.json'
        },
        url: {
            dev     : 'http://MYSITE/wp-content/themes/MYTHEME/prototype/dist'
        }
    };










/**
 * - - - - - - - - - - INCLUDE YOUR MODULES
 * - - - - - - - - - - - - - - - - - - - - -
 */

const prefix      = require('gulp-autoprefixer');
const beeper      = require('beeper');
const browserSync = require('browser-sync').create ();
const changed     = require('gulp-changed');
const colors      = require('ansi-colors');
const data        = require('gulp-data');
const fse         = require('fs-extra');
const gulp        = require('gulp');
const log         = require('fancy-log');
const njkRend     = require('gulp-nunjucks-render');
const normal      = require('node-normalize-scss');
const plumber     = require('gulp-plumber');
const reload      = browserSync.reload;
const sass        = require('gulp-sass');
const sourcemaps  = require('gulp-sourcemaps');
const uglify      = require('gulp-uglify');










/**
 * - - - - - - - - - - FUNCTIONS
 * - - - - - - - - - - - - - - -
 */

// Log errors and don't break the stream.
function onError(err) {
    console.log(err);
    beeper(2);
};

// Create a new proxy server to view dist.
function server() {
    browserSync.init ({
       proxy  : paths.url.dev,
       notify : false
    });
    log(colors.redBright.bold.bgWhiteBright("Excelsior! We're up and running."));
};

// Compile scss into css and reload proxy server.
// 'production' mode will compress final css output.
function style(env) {
    if (env !== true) {
        return gulp.src(paths.styles.watch)
        .pipe(sourcemaps.init())
        .pipe(sass({
            includePaths: normal.includePaths,
            outputStyle: 'expanded'
        }))
        .pipe(plumber({
              errorHandler : onError
          }))
        .pipe(prefix({
            grid: true,
            flexbox: true
        }))
        .pipe(sourcemaps.write('./')) //maps are set relative to source
        .pipe(gulp.dest(paths.styles.dest))
        .pipe(browserSync.stream());
    } else {
        return gulp.src(paths.styles.watch)
        .pipe(sourcemaps.init())
        .pipe(sass({
            includePaths: normal.includePaths,
            outputStyle: 'compressed'
        }))
        .pipe(sourcemaps.write('./')) //maps are set relative to source
        .pipe(gulp.dest(paths.styles.dest));
    }
}

// Save JavaScript to dist and reload browser.
// 'production' task will uglify final JavaScript output.
function script(env) {
    if (env !== true) {
        return gulp.src(paths.scripts.watch)
        .pipe(plumber({
              errorHandler : onError
          }))
        .pipe(gulp.dest(paths.scripts.dest))
        .pipe(browserSync.stream());
    } else {
        return gulp.src(paths.scripts.watch)
        .pipe(uglify())
        .pipe(gulp.dest(paths.scripts.dest));
    }
}

// Compile HTML on nunjuck change and reload proxy server.
function page() {
    return gulp.src(paths.pages.render)
    .pipe(data(function(file){
        return JSON.parse(fse.readFileSync('./src/data/data.json'))
    }))
    .pipe(njkRend({
        path:[paths.pages.compile]
    }))
    .pipe(plumber ({
        errorHandler : onError
    }))
    .pipe(gulp.dest(paths.pages.dest))
    .pipe(browserSync.stream());
}

// Images
function image() {
    return gulp.src(paths.images.watch)
    .pipe(changed(paths.images.dest))
    .pipe(gulp.dest(paths.images.dest))
    .pipe(browserSync.stream());
}

// Watching
function watch() {
    // watch source files
    gulp.watch(paths.scripts.watch, script);
    gulp.watch(paths.styles.watch, style);
    gulp.watch(paths.pages.watch, page);
    gulp.watch(paths.images.watch, image);
}










/**
 * - - - - - - - - - - TASKS
 * - - - - - - - - - - - - -
 */

// Render production ready assets
gulp.task('production', function(done) {
    style(true);
    script(true);
    page();
    image();
    done();
});

gulp.task('default', function() {
    style();
    script();
    page();
    image();
    server();
    watch();
    beeper();
});
