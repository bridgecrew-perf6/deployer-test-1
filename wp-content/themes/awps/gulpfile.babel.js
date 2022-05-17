import gulp from 'gulp';
import yargs from 'yargs';
import gulpif from 'gulp-if';
import newer from 'gulp-newer';
import del from 'del';
import plumber from "gulp-plumber";
import notify from "gulp-notify";
import zip from "gulp-zip";
import replace from "gulp-replace";
import info from "./package.json";

const PRODUCTION = yargs(process.argv).argv.prod;

// Paths
import {paths} from './settings.js';

// Styles
import dartSass from 'sass';
import gulpSass from 'gulp-sass';
import cleanCSS from 'gulp-clean-css';
import sourcemaps from 'gulp-sourcemaps';
import sassGlob from 'gulp-sass-glob';

const sass = gulpSass(dartSass);
import autoprefixer from 'gulp-autoprefixer';
import groupCssMediaQueries from 'gulp-group-css-media-queries';

// Scripts
import webpack from 'webpack-stream';
import named from 'vinyl-named';

// Images
import imagemin from 'gulp-imagemin';

// BrowserSync
import browserSync from "browser-sync";

const server = browserSync.create();

// Fonts
import fs from 'fs';
import fonter from 'gulp-fonter-fix';
import ttf2woff2 from 'gulp-ttf2woff2';

/*==================== Tasks ====================*/
export const serve = done => {
    server.init({
        proxy: "https://awps.loc"
    });
    done();
};

export const reload = done => {
    server.reload();
    done();
};

// Clean
export const clean = () => del(['assets']);

// Styles
export const styles = () => {
    return gulp.src(paths.styles.src)
        .pipe(plumber(
            notify.onError({
                title: "CSS",
                message: "Error: <%= error.message %>"
            })))
        .pipe(sassGlob())
        .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
        .pipe(sass({
            includePaths: ['./node_modules']
        }).on('error', sass.logError))
        .pipe(gulpif(PRODUCTION, groupCssMediaQueries()))
        .pipe(gulpif(PRODUCTION, autoprefixer({
            grid: true,
            overrideBrowserslist: ['last 3 versions'],
            cascade: true
        })))
        .pipe(gulpif(PRODUCTION, cleanCSS({
            compatibility: 'ie8'
        })))
        .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
        .pipe(gulp.dest(paths.styles.dest))
        .pipe(server.stream())
}

// Images
export const images = () => {
    return gulp.src(paths.images.src)
        .pipe(plumber(
            notify.onError({
                title: "IMAGES",
                message: "Error: <%= error.message %>"
            }))
        )
        .pipe(newer(paths.images.dest))
        .pipe(gulpif(PRODUCTION, imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            interlaced: true,
            optimizationLevel: 3 // 0 to 7
        })))
        .pipe(gulp.dest(paths.images.dest))
}

// Scripts
export const scripts = () => {
    return gulp
        .src(paths.scripts.src)
        .pipe(plumber(
            notify.onError({
                title: "JS",
                message: "Error: <%= error.message %>"
            }))
        )
        .pipe(named())
        .pipe(
            webpack({
                module: {
                    rules: [
                        {
                            test: /\.js$/,
                            use: {
                                loader: "babel-loader",
                                options: {
                                    presets: ["@babel/preset-env"]
                                }
                            }
                        }
                    ]
                },
                output: {
                    filename: "[name].js"
                },
                externals: {
                    jquery: "jQuery"
                },
                devtool: !PRODUCTION ? "inline-source-map" : false,
                mode: PRODUCTION ? 'production' : 'development'
            })
        )
        .pipe(gulp.dest(paths.scripts.dest));
};

export const otfToTtf = () => {
    // Ищем файлы шрифтов .otf
    return gulp.src(`${paths.fonts.src}/*.otf`, {})
        .pipe(plumber(
            notify.onError({
                title: "FONTS",
                message: "Error: <%= error.message %>"
            }))
        )
        // Конвертируем в .ttf
        .pipe(fonter({
            formats: ['ttf']
        }))
        // Выгружаем в исходную папку
        .pipe(gulp.dest(`${paths.fonts.src}`))
}
export const ttfToWoff = () => {
    // Ищем файлы шрифтов .ttf
    return gulp.src(`${paths.fonts.src}/*.ttf`, {})
        .pipe(plumber(
            notify.onError({
                title: "FONTS",
                message: "Error: <%= error.message %>"
            }))
        )
        // Конвертируем в .woff
        .pipe(fonter({
            formats: ['woff']
        }))
        // Выгружаем в папку с результатом
        .pipe(gulp.dest(`${paths.fonts.dest}`))
        // Ищем файлы шрифтов .ttf
        .pipe(gulp.src(`${paths.fonts.src}/*.ttf`))
        // Конвертируем в .woff2
        .pipe(ttf2woff2())
        // Выгружаем в папку с результатом
        .pipe(gulp.dest(`${paths.fonts.dest}`))
        // Ищем файлы шрифтов .woff и woff2
        .pipe(gulp.src(`${paths.fonts.src}/*.{woff,woff2}`))
        // Выгружаем в папку с результатом
        .pipe(gulp.dest(`${paths.fonts.dest}`));
}
export const fontStyle = () => {
    let fontsFile = `resources/scss/fonts/fonts.scss`;
    // Если передан флаг --rewrite удаляем файл подключения шрифтов
    process.argv.includes('--rewrite') ? fs.unlink(fontsFile, cb) : null;
    // Проверяем существуют ли файлы шрифтов
    fs.readdir(paths.fonts.dest, function (err, fontsFiles) {
        if (fontsFiles) {
            // Проверяем существует ли файл стилей для подключения шрифтов
            if (!fs.existsSync(fontsFile)) {
                // Если файла нет, создаем его
                fs.writeFile(fontsFile, '', cb);
                let newFileOnly;
                for (var i = 0; i < fontsFiles.length; i++) {
                    // Записываем подключения шрифтов в файл стилей
                    let fontFileName = fontsFiles[i].split('.')[0];
                    if (newFileOnly !== fontFileName) {
                        let fontName = fontFileName.split('-')[0] ? fontFileName.split('-')[0] : fontFileName;
                        let fontWeight = fontFileName.split('-')[1] ? fontFileName.split('-')[1] : fontFileName;
                        if (fontWeight.toLowerCase() === 'thin') {
                            fontWeight = 100;
                        } else if (fontWeight.toLowerCase() === 'extralight') {
                            fontWeight = 200;
                        } else if (fontWeight.toLowerCase() === 'light') {
                            fontWeight = 300;
                        } else if (fontWeight.toLowerCase() === 'medium') {
                            fontWeight = 500;
                        } else if (fontWeight.toLowerCase() === 'semibold') {
                            fontWeight = 600;
                        } else if (fontWeight.toLowerCase() === 'bold') {
                            fontWeight = 700;
                        } else if (fontWeight.toLowerCase() === 'extrabold' || fontWeight.toLowerCase() === 'heavy') {
                            fontWeight = 800;
                        } else if (fontWeight.toLowerCase() === 'black') {
                            fontWeight = 900;
                        } else {
                            fontWeight = 400;
                        }
                        fs.appendFile(fontsFile, `@font-face {\n\tfont-family: ${fontName};\n\tfont-display: swap;\n\tsrc: url("../fonts/${fontFileName}.woff2") format("woff2"), url("../fonts/${fontFileName}.woff") format("woff");\n\tfont-weight: ${fontWeight};\n\tfont-style: normal;\n}\r\n`, cb);
                        newFileOnly = fontFileName;
                    }
                }
            } else {
                // Если файл есть, выводим сообщение
                console.log("Файл scss/fonts/fonts.scss уже существует. Для обновления файла нужно его удалить!");

            }
        } else {
            // Если шрифтов нет
            fs.unlink(fontsFile, cb)
        }
    });
    return gulp.src(`${paths.fonts.src}`);
}

function cb() {
}

// Copy
export const copy = () => {
    return gulp.src(paths.other.src)
        .pipe(gulp.dest(paths.other.dest));
}

export const compress = () => {
    return gulp
        .src(paths.package.src, {base: '../'})
        .pipe(
            gulpif(
                file => file.relative.split('.').pop() !== 'zip',
                replace('awps', info.name)
            )
        )
        .pipe(zip(`${info.name}.zip`))
        .pipe(gulp.dest(paths.package.dest));
};

// Watch
export const watch = () => {
    gulp.watch(['resources/scss/**/*.scss'], styles)
    gulp.watch(['resources/js/**/*.js'], gulp.series(scripts, reload))
    gulp.watch(['**/*.php'], reload)
    gulp.watch(paths.images.src, gulp.series(images, reload))
    gulp.watch(paths.other.src, gulp.series(copy, reload))
}

export const fonts = gulp.series(otfToTtf, ttfToWoff, fontStyle);
export const dev = gulp.series(clean, gulp.parallel(fonts, styles, scripts, images, copy), serve, watch);
export const php = gulp.series(serve, watch);
export const build = gulp.series(clean, gulp.parallel(fonts, styles, scripts, images), copy);
export const bundle = gulp.series(build, compress);

export default dev;
