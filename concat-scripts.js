/**
 * Plain file concatenation for legacy jQuery bundles.
 * Use instead of mix.scripts() to avoid webpack module-scope issues
 * (jQuery would export via module.exports instead of window.$).
 */
const fs   = require('fs');
const path = require('path');

const bundles = [
    {
        output: 'public/js/parts_main/bundle.js',
        files: [
            'public/js/jquery-3.3.1.min.js',
            'public/js/jquery.form.min.js',
            'public/js/bootstrap.min.js',
            'public/fancybox-3/dist/jquery.fancybox.min.js',
            'public/js/jquery.inputmask.min.js',
            'public/js/app.js',
            'public/js/parts_main/app.js',
        ],
    },
];

bundles.forEach(({ output, files }) => {
    const content = files.map(f => {
        const full = path.resolve(f);
        if (!fs.existsSync(full)) {
            console.warn(`  WARN  missing: ${f}`);
            return '';
        }
        return fs.readFileSync(full, 'utf8');
    }).join('\n');

    fs.mkdirSync(path.dirname(path.resolve(output)), { recursive: true });
    fs.writeFileSync(path.resolve(output), content);

    const kb = (content.length / 1024).toFixed(1);
    console.log(`  DONE  ${output} (${kb} KB)`);
});
