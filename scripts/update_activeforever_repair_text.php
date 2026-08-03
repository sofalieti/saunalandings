<?php
/**
 * Update REPAIR_TEXT for Active Forever brand (flat files + SQLite when FLAT_CONTENT=true).
 *
 * Run on server:
 *   cd /var/www/www-root/data/www/activeforeversaunaparts.com
 *   /opt/php71/bin/php scripts/update_activeforever_repair_text.php
 *   # or /opt/php74/bin/php if 7.1 CLI lacks extensions
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$host = 'activeforeversaunaparts.com';

$brand = App\Brand::where('active', 1)
    ->whereRaw('LOWER(domain) = ?', [$host])
    ->first();

if (!$brand) {
    fwrite(STDERR, "Brand not found for {$host}\n");
    exit(1);
}

$block = $brand->brand_text_blocks()
    ->where('var_name', 'REPAIR_TEXT')
    ->first();

if (!$block) {
    fwrite(STDERR, "REPAIR_TEXT block not found for brand id={$brand->id}\n");
    exit(1);
}

$html = <<<'HTML'
<p>Having trouble with your <strong>Active Forever infrared sauna</strong>? Most issues come down to a handful of parts — heaters, the control panel / touch pad, the control power box, fuses, relays, or wiring connectors. We specialize in Active Forever parts and can usually point you to the right fix from a clear description and a couple of photos.</p>

<p><strong>Before you start:</strong> unplug the sauna (or turn off the dedicated breaker). Do not open the control power box or touch wiring while power is on. If you smell burning plastic, see scorch marks, or the breaker trips repeatedly, stop and contact us before replacing parts.</p>

<h3>How Active Forever repairs usually go</h3>
<ol>
<li><strong>Confirm the model.</strong> Check the label inside the cabin (often near the control panel or door). Note the exact model name and, if present, serial number — Active Forever layouts and part connectors vary by year.</li>
<li><strong>Describe what fails.</strong> Examples: no power at all; panel lights up but heaters stay cold; one wall/heater zone cold; session stops early; chromotherapy or audio dead; fan noisy or not running.</li>
<li><strong>Match the symptom to the part group</strong> (use our parts categories on this page):
<ul>
<li>No power / dead panel → fuses, breakers, power supply, control power box, main wiring harness</li>
<li>Panel on, no heat (or one zone cold) → heaters, relays / solid-state relays, heater wiring connectors</li>
<li>Wrong temperature / won’t start session → touch pad / control panel, remote, power board</li>
<li>Lights, ionizer, audio, fan only → those accessory categories (not usually the heaters)</li>
</ul>
</li>
<li><strong>Replace the failed part with the correct Active Forever–compatible unit.</strong> Photos of the part (labels, connector shape, board markings) avoid ordering the wrong revision.</li>
<li><strong>After install:</strong> restore power, run a short test session, and confirm each heater zone and the panel respond normally.</li>
</ol>

<p><strong>Warranty note:</strong> Active Forever typically offers a limited lifetime warranty on heaters and about three years on other electrics. If your unit may still be covered, keep the old part and your purchase info — we can still help identify the replacement while you check warranty options.</p>

<p><strong>Send us these details in the form</strong> (faster diagnosis = faster parts match):</p>
<ul>
<li>Exact Active Forever model (and year/serial if you have them)</li>
<li>What happens step-by-step (and whether it started suddenly or got worse over time)</li>
<li>Which zone or feature fails (left wall, back heaters, control panel, etc.)</li>
<li>Clear photos of the suspect part, connectors, and any error lights or burn marks</li>
<li>Whether you already replaced a fuse, relay, or heater (and what changed)</li>
</ul>

<p>Use the free consult form on this page — the clearer the description, the quicker we can tell you whether you need a single part, a board, or a short DIY check before ordering. We’re here to get your Active Forever sauna heating reliably again.</p>
HTML;

$block->description = $html;
$block->save();

$slug = $brand->slug ?: ('id-' . $brand->id);
$path = "content/brands/{$slug}/text_blocks/{$block->id}.json";

echo "OK brand_id={$brand->id} slug={$slug} block_id={$block->id}\n";
echo "Updated REPAIR_TEXT → {$path}\n";
echo "FLAT=" . (config('flat.enabled') ? '1' : '0') . "\n";
