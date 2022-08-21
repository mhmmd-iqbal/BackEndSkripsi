<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstrumentSubTopic extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'instrument_sub_topics';

    protected $fillable = [
        'instrument_topic_id',
        'name',
        'is_available'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $hidden = [
        'instrument_topic_id',
        'deleted_at',
    ];

    public function topic()
    {
        return $this->belongsTo(InstrumentTopic::class, 'instrument_topic_id', 'id');
    }

    public function instruments()
    {
        return $this->hasMany(Instrument::class, 'instrument_sub_topic_id', 'id');
    }

    public function scopeIsAvailable($query)
    {
        return $query->where('is_available', true);
    }
}
