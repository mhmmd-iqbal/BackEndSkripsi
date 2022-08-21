<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstrumentTopic extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'instrument_topics';

    protected $fillable = [
        'period_id',
        'name',
        'is_available'
    ];

    protected $hidden = [
        'period_id',
        'deleted_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id', 'id');
    }

    public function subTopics()
    {
        return $this->hasMany(InstrumentSubTopic::class, 'instrument_topic_id', 'id');
    }

    public function scopeIsAvailable($query)
    {
        return $query->where('is_available', true);
    }
}
