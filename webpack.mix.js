const mix = require('laravel-mix');

mix
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')

    /*
     * CSS bundle for parts_main template.
     * All 6 separate CSS requests → 1 file.
     * Font paths in opensans and fontawesome are absolute so bundling is safe.
     */
    .styles([
        'public/css/bootstrap.min.css',
        'public/fancybox-3/dist/jquery.fancybox.min.css',
        'public/fonts/opensans/stylesheetfonts.css',
        'public/fontawesome-free-5.8.1/css/all-abs.min.css',
        'public/css/parts_main/app.css',
        'public/css/parts_main/app-responsive.css',
    ], 'public/css/parts_main/bundle.css')

    .version();
