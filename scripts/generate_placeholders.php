<?php

use App\Models\Formation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$gradients = [
    ['#1D4ED8', '#60A5FA'],
    ['#0F766E', '#5EEAD4'],
    ['#7C3AED', '#C4B5FD'],
    ['#B45309', '#FCD34D'],
    ['#BE123C', '#FDA4AF'],
    ['#374151', '#9CA3AF'],
];

$formations = Formation::orderBy('id')->get();

foreach ($formations as $index => $formation) {
    if (!empty($formation->image)) {
        continue;
    }

    $colors = $gradients[$index % count($gradients)];
    $start = $colors[0];
    $end = $colors[1];

    $label = 'FORMATION';
    $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="700" viewBox="0 0 1200 700">
  <defs>
    <linearGradient id="grad" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="{$start}"/>
      <stop offset="100%" stop-color="{$end}"/>
    </linearGradient>
  </defs>
  <rect width="1200" height="700" fill="url(#grad)"/>
  <circle cx="980" cy="140" r="120" fill="rgba(255,255,255,0.15)"/>
  <circle cx="260" cy="520" r="180" fill="rgba(255,255,255,0.12)"/>
  <rect x="120" y="210" width="520" height="60" rx="30" fill="rgba(255,255,255,0.18)"/>
  <text x="120" y="250" font-family="Arial, sans-serif" font-size="36" fill="white" letter-spacing="2">{$label}</text>
</svg>
SVG;

    $path = 'formations/placeholders/formation-' . $formation->id . '.svg';
    Storage::disk('public')->put($path, $svg);

    $formation->image = $path;
    $formation->save();
}

echo "Placeholders generated and assigned." . PHP_EOL;
