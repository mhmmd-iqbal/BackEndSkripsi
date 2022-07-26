<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'departments';

    protected $fillable = [
        'user_id',
        'level', 
        'name',
        'scope_type',
        'major_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $hidden = [
        'deleted_at',
        'user_id'
    ];

    protected $with = [
        'major'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function auditForms()
    {
        return $this->hasMany(AuditForm::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id', 'id');
    }
}
