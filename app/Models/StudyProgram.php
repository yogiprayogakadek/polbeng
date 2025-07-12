<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class StudyProgram extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['uuid', 'department_id', 'study_program_code', 'study_program_name', 'is_active'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function projectCategories()
    {
        return $this->hasMany(ProjectCategory::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = str_replace('-', '', Uuid::uuid4()->getHex());
        });
    }
}
