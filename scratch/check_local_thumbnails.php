<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\Project;

$projects = Project::where('thumbnail', 'not like', 'http%')->get();
foreach ($projects as $p) {
    echo "ID: {$p->id}, Title: {$p->project_title}, Thumbnail: {$p->thumbnail}\n";
}
