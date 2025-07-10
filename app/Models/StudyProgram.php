<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudyProgram extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['department_id', 'study_program_code', 'study_program_name', 'is_active'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function projectCategories()
    {
        return $this->hasMany(ProjectCategory::class);
    }
}
