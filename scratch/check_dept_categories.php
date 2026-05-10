<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\Department;
use App\Models\ProjectCategory;

$depts = Department::all();
foreach ($depts as $d) {
    $count = ProjectCategory::whereHas('studyProgram', function($q) use ($d) {
        $q->where('department_id', $d->id);
    })->count();
    echo "Dept: {$d->department_name}, Categories: $count\n";
}
