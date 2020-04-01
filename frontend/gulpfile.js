"use strict";

var gulp = require('gulp');
var sass = require("gulp-sass");
var plumber = require("gulp-plumber");
var posthtml = require("gulp-posthtml");
var include = require("posthtml-include");
var postcss = require("gulp-postcss");
var prefixer = require("autoprefixer");
var minify = require("gulp-csso");
var rename = require("gulp-rename");
var server = require("browser-sync");
var svgstore = require("gulp-svgstore");
var webp = require("gulp-webp");
var imagemin = require("gulp-imagemin");
var del = require("del");
var run = require("run-sequence");
var browserSync = require('browser-sync');
var cssmin = require('gulp-minify-css');
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');
var reload = browserSync.reload;
var minify = require('gulp-minify');

var path = {
    public: {
        // html: '../public/',
        js: '../public/js/',
        css: '../public/css/',
        img: '../public/img/',
        fonts: '../public/fonts/'
    },
    src: {
        // html: './source/*.html',
        js: './source/js/*.js',
        style: './source/sass/style.scss',
        styleit: './source/sass/main.scss',
        img: './source/img/*.*',
        fonts: './source/fonts/**/*.*'
    },
    // clean: '../public'
};

var config = {
    server: {
        baseDir: "../public"
    },
    tunnel: true,
    host: 'localhost',
    port: 9000,
    logPrefix: "Frontend_Devil"
};

// gulp.task('watch', function () {

//     browserSync.init(null, {
//         notify: false,
//         proxy: '192.168.1.2:3000/',
//         open: false,
//         files: [
//             'source/sass/style.scss',
//             'source/*.html',
//             'source/js/*.js',
//         ],
//         watchOptions: {
//             usePolling: true,
//             interval: 500
//         }
//     })
//     });

    // gulp.task('html:build', function () {
    //     gulp.src(path.src.html)
    //         .pipe(gulp.dest(path.public.html))
    //         .pipe(reload({stream: true})); c
    // });

    gulp.task('js:build', function () {
        gulp.src(path.src.js)
            .pipe(minify())
            .pipe(gulp.dest(path.public.js))
            /*.pipe(reload({stream: true}));*/
    });

    gulp.task('style:build', function () {
        gulp.src(path.src.style)
            .pipe(sass())
            .pipe(postcss([ prefixer() ]))
            .pipe(cssmin())
            .pipe(gulp.dest(path.public.css))
            /*.pipe(reload({stream: true}));*/
    });

    gulp.task('styleit:build', function () {
        gulp.src(path.src.styleit)
            .pipe(sass())
            .pipe(postcss([ prefixer() ]))
            .pipe(cssmin())
            .pipe(gulp.dest(path.public.css))
            /*.pipe(reload({stream: true}));*/
    });

    gulp.task('img:build', function () {
        gulp.src(path.src.img)
            .pipe(imagemin({
                progressive: true,
                svgoPlugins: [{removeViewBox: false}],
                use: [pngquant()],
                interlaced: true
            }))
            .pipe(gulp.dest(path.public.img))
             /*.pipe(reload({stream: true}));;*/
    });

    gulp.task('fonts:build', function() {
        gulp.src(path.src.fonts)
            .pipe(gulp.dest(path.public.fonts))
    });

    gulp.task('build', [
        // 'html:build',
        'js:build',
        'style:build',
        'styleit:build',
        'fonts:build',
        'img:build'
    ]);

    gulp.task('webserver', function () {
        browserSync(config);
    });

    gulp.task('clean', function (cb) {
        rimraf(path.clean, cb);
    });

    gulp.task('default', ['build', 'webserver', 'watch']);
