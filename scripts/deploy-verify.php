<?php
/**
 * Prints what the production server actually has after a deploy: the build of
 * the parts_category_v2 stylesheet and a few values read back from the flat
 * content index the site renders from.
 *
 * Usage: php scripts/deploy-verify.php
 * Always exits 0 — this reports, it does not gate the deploy.
 */

$root = dirname(__DIR__);

function line($label, $value)
{
    echo 'verify: ' . $label . ' = ' . $value . "\n";
}

$css = $root . '/public/css/parts_category_v2/app.css';
if (is_file($css)) {
    $body = (string) file_get_contents($css);
    line('v2 stylesheet', strpos($body, '--color-signal-blue') !== false ? 'augen build' : 'OLD BUILD (augen palette missing)');
    line('v2 stylesheet bytes', strlen($body));
    line('v2 stylesheet mtime', date('Y-m-d H:i:s', filemtime($css)));
} else {
    line('v2 stylesheet', 'MISSING');
}

$index = $root . '/storage/flat/content.sqlite';
if (!is_file($index)) {
    line('flat index', 'MISSING');
    exit(0);
}

line('flat index mtime', date('Y-m-d H:i:s', filemtime($index)));

try {
    $db = new PDO('sqlite:' . $index);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $h1 = $db->query("select description from brand_text_blocks where brand_id = 1134 and var_name = 'main_page_text_block_header'")->fetchColumn();
    line('fans H1', $h1 === false ? '(none)' : $h1);

    $title = $db->query("select meta_title from brands where id = 1134")->fetchColumn();
    line('fans meta title', $title === false ? '(none)' : $title);

    $plugBlocks = $db->query("select count(*) from brand_text_blocks where description like '%[PLUG]%'")->fetchColumn();
    line('text blocks still holding placeholders', $plugBlocks);

    $plugBrands = $db->query("select count(*) from brands where meta_title like '%[PLUG]%' or meta_description like '%[PLUG]%'")->fetchColumn();
    line('brands still holding placeholder meta', $plugBrands);
} catch (Exception $e) {
    line('flat index read', 'FAILED: ' . $e->getMessage());
}

exit(0);
