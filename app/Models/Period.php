<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $table = 'periods';

    protected $fillable = [
        'name',
        'period_start',
        'period_end'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
        'period_start' => 'datetime:Y-m-d',
        'period_end'   => 'datetime:Y-m-d',
    ];

    public function InstrumentTopics() {
        return $this->hasMany(InstrumentTopic::class, 'period_id', 'id');
    }

    public function auditForms()
    {
        return $this->hasMany(AuditForm::class);
    }
}
