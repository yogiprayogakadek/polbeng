<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class ProjectCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['uuid', 'study_program_id', 'project_category_name', 'is_active'];

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class);
    }

    public function galleries()
    {
        return $this->hasMany(ProjectGallery::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = str_replace('-', '', Uuid::uuid4()->getHex());
        });
    }
}
