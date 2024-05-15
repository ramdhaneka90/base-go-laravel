const mix = require('laravel-mix');
const exec = require('child_process').exec
require('dotenv').config()
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

const source = 'node_modules';
const dest = 'resources/';
const glob = require('glob')
const path = require('path')

/*
 |--------------------------------------------------------------------------
 | Vendor assets
 |--------------------------------------------------------------------------
 */

function mixAssetsDir(query, cb) {
    ; (glob.sync('resources/' + query) || []).forEach(f => {
        f = f.replace(/[\\\/]+/g, '/')
        cb(f, f.replace('resources', 'public'))
    })
}

mix.autoload({
    jquery: ['$', 'jQuery'],
});

mix
    .js("resources/js/app.js", "public/js")
    .scripts(
        [
            "public/js/app.js",
            "resources/js/messages.js",
            "resources/js/helpers/common.js",
            "resources/js/helpers/menu.js",
        ],
        "public/js/app.min.js"
    )
    .sass("resources/build/scss/adminlte.scss", "public/css/app.min.css")
    .css("resources/css/app.css", "public/css/style.min.css");

if (mix.inProduction()) {
    mix.version();
}

// copy plugin files to resource folder

mix
    .copy(source + "/@fortawesome/fontawesome-free/css/all.min.css", dest + "plugins/css/fortawesome/fontawesome.min.css")
    .copyDirectory(source + "/@fortawesome/fontawesome-free/webfonts", dest + "plugins/css/webfonts")
    .copy(source + "/@fortawesome/fontawesome-free/js/all.min.js", dest + "plugins/js/fortawesome/fontawesome.min.js")
    .copy(source + "/@lgaitan/pace-progress/dist/pace.min.js", dest + "plugins/js/lgaitan/pace-progress/pace.min.js")
    .copy(source + "/@sweetalert2/theme-bootstrap-4/bootstrap-4.min.css", dest + "plugins/css/sweetalert2/theme-bootstrap-4/bootstrap-4.min.css")
    .copy(source + "/@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css", dest + "plugins/css/select2-bootstrap4-theme/select2-bootstrap4.min.css")
    .copy(source + "/bootstrap/dist/js/bootstrap.bundle.min.js", dest + "plugins/js/bootstrap/bootstrap.bundle.min.js")
    .copy(source + "/bootstrap/dist/css/bootstrap.min.css", dest + "plugins/css/bootstrap/bootstrap.min.css")
    .copy(source + "/bs-custom-file-input/dist/bs-custom-file-input.min.js", dest + "plugins/js/bs-custom-file-input/bs-custom-file-input.min.js")
    .copy(source + "/bs-stepper/dist/css/bs-stepper.min.css", dest + "plugins/css/bs-stepper/bs-stepper.min.css")
    .copy(source + "/bs-stepper/dist/js/bs-stepper.min.js", dest + "plugins/js/bs-stepper/bs-stepper.min.js")
    .copy(source + "/chart.js/dist/Chart.min.css", dest + "plugins/css/chart/Chart.min.css")
    .copy(source + "/chart.js/dist/Chart.bundle.min.js", dest + "plugins/js/chart/Chart.bundle.min.js")
    .copy(source + "/codemirror/lib/codemirror.css", dest + "plugins/css/codemirror/codemirror.css")
    .copy(source + "/codemirror/lib/codemirror.js", dest + "plugins/js/codemirror/codemirror.js")
    .copy(source + "/datatables.net/js/jquery.dataTables.min.js", dest + "plugins/js/datatables.net/jquery.dataTables.min.js")
    .copy(source + "/datatables.net-bs4/css/dataTables.bootstrap4.min.css", dest + "plugins/css/datatables.net-bs4/dataTables.bootstrap4.min.css")
    .copy(source + "/datatables.net-bs4/js/dataTables.bootstrap4.min.js", dest + "plugins/js/datatables.net-bs4/dataTables.bootstrap4.min.js")
    .copy(source + "/daterangepicker/daterangepicker.css", dest + "plugins/css/daterangepicker/daterangepicker.css")
    .copy(source + "/daterangepicker/daterangepicker.js", dest + "plugins/js/daterangepicker/daterangepicker.js")
    .copy(source + "/icheck-bootstrap/icheck-bootstrap.min.css", dest + "plugins/css/icheck-bootstrap/icheck-bootstrap.min.css")
    .copy(source + "/inputmask/dist/jquery.inputmask.min.js", dest + "plugins/js/inputmask/jquery.inputmask.min.js")
    .copy(source + "/jquery/dist/jquery.min.js", dest + "plugins/js/jquery/jquery.min.js")
    .copy(source + "/jquery-validation/dist/jquery.validate.min.js", dest + "plugins/js/jquery-validation/jquery.validate.min.js")
    .copy(source + "/moment/dist/moment.js", dest + "plugins/js/moment/moment.js")
    .copy(source + "/overlayscrollbars/css/OverlayScrollbars.min.css", dest + "plugins/css/overlayscrollbars/OverlayScrollbars.min.css")
    .copy(source + "/overlayscrollbars/js/jquery.overlayScrollbars.min.js", dest + "plugins/js/overlayscrollbars/jquery.overlayScrollbars.min.js")
    .copy(source + "/popper.js/dist/popper.min.js", dest + "plugins/js/popper/popper.min.js")
    .copy(source + "/select2/dist/css/select2.min.css", dest + "plugins/css/select2/select2.min.css")
    .copy(source + "/select2/dist/js/select2.full.min.js", dest + "plugins/js/select2/select2.full.min.js")
    .copy(source + "/sweetalert2/dist/sweetalert2.all.min.js", dest + "plugins/js/sweetalert2/sweetalert2.all.min.js")
    .copy(source + "/sweetalert2/dist/sweetalert2.min.css", dest + "plugins/css/sweetalert2/sweetalert2.min.css")
    .copy(source + "/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js", dest + "plugins/js/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.js")
    .copy(source + "/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css", dest + "plugins/css/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css")
    .copy(source + "/toastr/build/toastr.min.css", dest + "plugins/css/toastr/toastr.min.css")
    .copy(source + "/toastr/build/toastr.min.js", dest + "plugins/js/toastr/toastr.min.js")
    .copy(source + "/uuid-js/lib/uuid.js", dest + "plugins/js/uuid-js/uuid.js")
    .copy(source + "/handlebars/dist/handlebars.min.js", dest + "plugins/js/handlebars/handlebars.min.js")
    .copy(source + "/nestable2/dist/jquery.nestable.min.css", dest + "plugins/css/nestable2/jquery.nestable.min.css")
    .copy(source + "/nestable2/dist/jquery.nestable.min.js", dest + "plugins/js/nestable2/jquery.nestable.min.js")
    .copy(source + "/waitme/waitMe.min.css", dest + "plugins/css/waitme/waitMe.min.css")
    .copy(source + "/waitme/waitMe.min.js", dest + "plugins/js/waitme/waitMe.min.js")
    .copy(source + "/vue/dist/vue.min.js", dest + "plugins/js/vue/vue.min.js")
    .copy(source + "/vue/dist/vue.js", dest + "plugins/js/vue/vue.js")
    .copy(source + "/bs-custom-file-input/dist/bs-custom-file-input.min.js", dest + "plugins/js/bs-custom-file-input/bs-custom-file-input.min.js")
    ;


mixAssetsDir('plugins/js/**/*.js', (src, dest) => mix.scripts(src, dest))
mixAssetsDir('plugins/css/**/*.css', (src, dest) => mix.copy(src, dest))
mixAssetsDir('plugins/css/webfonts', (src, dest) => mix.copyDirectory(src, dest))
mixAssetsDir('js/adminlte.min.js', (src, dest) => mix.copy(src, dest))
