<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'project_category_id',
        'dosen_pembimbing_id',
        'project_title',
        'school_year',
        'semester',
        'thumbnail',
        'status',
        'rejection_reason',
        'is_active'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_VERIFIED_DOSEN = 'verified_by_dosen';
    const STATUS_REJECTED_DOSEN = 'rejected_by_dosen';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED_KAPRODI = 'rejected_by_kaprodi';

    public function dosenPembimbing()
    {
        return $this->belongsTo(User::class, 'dosen_pembimbing_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function projectCategory()
    {
        return $this->belongsTo(ProjectCategory::class);
    }

    public function detail()
    {
        return $this->hasOne(ProjectDetail::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = str_replace('-', '', Uuid::uuid4()->getHex());
        });
    }
}
