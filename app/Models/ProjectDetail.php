<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class ProjectDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'project_id',
        'members',
        'description',
        'video_trailer_url',
        'presentation_video_url',
        'poster_path'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = str_replace('-', '', Uuid::uuid4()->getHex());
        });
    }

    public function galleries()
    {
        return $this->hasMany(ProjectGallery::class);
    }
}
