<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['uuid', 'department_code', 'department_name', 'is_active'];

    protected static function booted()
    {
        static::deleting(function ($department) {
            if ($department) {
                $department->is_active = false;
                $department->save();
            }
        });

        static::restoring(function ($department) {
            if ($department->user) {
                $department->is_active = true;
                $department->save();
            }
        });
    }

    public function studyPrograms()
    {
        return $this->hasMany(StudyProgram::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = str_replace('-', '', Uuid::uuid4()->getHex());
        });
    }
}
