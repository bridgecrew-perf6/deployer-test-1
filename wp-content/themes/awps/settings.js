export const paths = {
    styles: {
        src: ['resources/scss/main.scss', 'resources/scss/main.scss'],
        dest: 'assets/css'
    },
    images: {
        src: 'resources/images/**/*.{jpg,jpeg,png,svg,gif}',
        dest: 'assets/images'
    },
    scripts: {
        src: ['resources/js/app.js', 'resources/js/app.js'],
        dest: 'assets/js'
    },
    fonts: {
        src: 'resources/fonts',
        dest: 'assets/fonts'
    },
    other: {
        src: [
            'resources/**/*',
            '!resources/{images,js,scss}',
            '!resources/{images,js,scss}/**/*',
            '!resources/fonts',
            '!resources/fonts/**/*',
        ],
        dest: 'assets'
    },
    package: {
        src: [
            "**/*",
            "!.vscode",
            "!.idea",
            "!node_modules{,/**}",
            "!packaged{,/**}",
            "!resources{,/**}",
            "!.babelrc",
            "!.gitignore",
            "!gulpfile.babel.js",
            "!settings.js",
            "!package.json",
            "!package-lock.json",
        ],
        dest: 'packaged'
    }
}
