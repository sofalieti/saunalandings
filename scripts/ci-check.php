<?php
/**
 * CI checks for flat content + basic project health (no Laravel bootstrap).
 *
 * Usage: php scripts/ci-check.php
 * Exit 0 = OK, 1 = failures.
 */

$root = dirname(__DIR__);
$errors = [];
$warnings = [];

function fail($msg, array &$errors)
{
    $errors[] = $msg;
}

function walkJsonFiles($dir)
{
    $out = [];
    if (!is_dir($dir)) {
        return $out;
    }
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)
    );
    foreach ($it as $file) {
        if ($file->isFile() && strtolower($file->getExtension()) === 'json') {
            $out[] = $file->getPathname();
        }
    }
    sort($out);
    return $out;
}

// --- 1) content/ must exist ---
$contentDir = $root . DIRECTORY_SEPARATOR . 'content';
if (!is_dir($contentDir)) {
    fail('Missing content/ directory', $errors);
}

// --- 2) Validate every JSON under content/ ---
$jsonFiles = walkJsonFiles($contentDir);
$okCount = 0;
foreach ($jsonFiles as $path) {
    $rel = str_replace('\\', '/', substr($path, strlen($root) + 1));
    $raw = file_get_contents($path);
    if ($raw === false) {
        fail("Cannot read {$rel}", $errors);
        continue;
    }
    json_decode($raw, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        fail("Invalid JSON {$rel}: " . json_last_error_msg(), $errors);
        continue;
    }
    $okCount++;
}

if (count($jsonFiles) === 0) {
    fail('No JSON files found under content/', $errors);
}

// --- 3) Active Forever brand + REPAIR_TEXT ---
$brandJson = $contentDir . '/brands/active-forever/brand.json';
if (!is_file($brandJson)) {
    fail('Missing content/brands/active-forever/brand.json', $errors);
} else {
    $brand = json_decode(file_get_contents($brandJson), true);
    $domain = isset($brand['domain']) ? strtolower((string) $brand['domain']) : '';
    if ($domain !== 'activeforeversaunaparts.com') {
        fail('active-forever brand domain expected activeforeversaunaparts.com, got: ' . ($brand['domain'] ?? '(empty)'), $errors);
    }
}

$repairPath = null;
$repairBlocks = walkJsonFiles($contentDir . '/brands/active-forever/text_blocks');
foreach ($repairBlocks as $path) {
    $data = json_decode(file_get_contents($path), true);
    if (!is_array($data)) {
        continue;
    }
    if (isset($data['var_name']) && $data['var_name'] === 'REPAIR_TEXT') {
        $repairPath = $path;
        $desc = isset($data['description']) ? trim(strip_tags((string) $data['description'])) : '';
        if ($desc === '') {
            fail('Active Forever REPAIR_TEXT has empty description', $errors);
        }
        if (empty($data['active'])) {
            fail('Active Forever REPAIR_TEXT is not active', $errors);
        }
        break;
    }
}
if ($repairPath === null) {
    fail('Active Forever REPAIR_TEXT text block not found', $errors);
}

// --- 4) Critical PHP app files must exist ---
foreach (['app/Http/Middleware/Landing.php', 'app/FlatFile/Index.php', 'config/flat.php'] as $rel) {
    if (!is_file($root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $rel))) {
        fail("Missing required file: {$rel}", $errors);
    }
}

// --- Report ---
echo "ci-check: scanned {$okCount} JSON file(s) under content/\n";
if ($repairPath) {
    $rel = str_replace('\\', '/', substr($repairPath, strlen($root) + 1));
    echo "ci-check: REPAIR_TEXT OK ({$rel})\n";
}

if ($warnings) {
    foreach ($warnings as $w) {
        echo "WARNING: {$w}\n";
    }
}

if ($errors) {
    echo "FAILED (" . count($errors) . "):\n";
    foreach ($errors as $e) {
        echo "  - {$e}\n";
    }
    exit(1);
}

echo "ci-check: OK\n";
exit(0);
