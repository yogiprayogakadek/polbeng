<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['study_program_id', 'project_category_name', 'is_active'];

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class);
    }

    public function galleries()
    {
        return $this->hasMany(ProjectGallery::class);
    }
}
