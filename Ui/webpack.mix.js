const mix = require('laravel-mix');

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

mix.js([
    'resources/js/app.js',
    //--------------- TallAndSassy There is definitely a better way -------------------------------------------------------------------------------------
    'vendor/tallandsassy/tallandsassy/Ui/resources/js/app.js',
    //'submodules/TallAndSassy/Cms/resources/js/jckeditor.js',
    'resources/js/jckeditor.js',
    //--------------- Ckeditor WIP -------------------------------------------------------------------------------------

], 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .postCss('vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/public/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .postCss('vendor/tallandsassy/tallandsassy/PageGuide/page-guide-admin/resources/public/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ]) // We can probably combine all module .css into one array, like in the mix.js above. But, there is also an probably and automated way, too.;

if (mix.inProduction()) {
    mix.version();
}

/**
 * CK Editor Config
 */
const CKEStyles = require('@ckeditor/ckeditor5-dev-utils').styles
const CKERegex = {
    svg: /ckeditor5-[^/\\]+[/\\]theme[/\\]icons[/][^/\\]+\.svg$/,
    css: /ckeditor5-[^/\\]+[/\\]theme[/\\].+\.css$/
}

Mix.listen('configReady', webpackConfig => {
    const rules = webpackConfig.module.rules
    const targetSVG = /(\.(png|jpe?g|gif|webp)$|^((?!font).)*\.svg$)/
    const targetFont = /(\.(woff2?|ttf|eot|otf)$|font.*\.svg$)/
    const targetCSS = /\.css$/

    // Exclude CK Editor regex from mix's default rules
    for (let rule of rules) {
        if (rule.test.toString() === targetSVG.toString()) {
            rule.exclude = CKERegex.svg
        } else if (rule.test.toString() === targetFont.toString()) {
            rule.exclude = CKERegex.svg
        } else if (rule.test.toString() === targetCSS.toString()) {
            rule.exclude = CKERegex.css
        }
    }
})

/**
 * Webpack Config for CK Editor
 */
mix.webpackConfig({
    module: {
        rules: [
            {
                test: CKERegex.svg,
                use: ['raw-loader']
            },
            {
                test: CKERegex.css,
                use: [
                    {
                        loader: 'postcss-loader',
                        options: {
                            postcssOptions: CKEStyles.getPostCssConfig({
                                themeImporter: {
                                    themePath: require.resolve('@ckeditor/ckeditor5-theme-lark')
                                },
                                minify: true
                            })
                        }
                    }
                ]
            }
        ]
    }
})
