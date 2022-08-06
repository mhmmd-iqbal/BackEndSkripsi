<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory;

    protected $table = 'instruments';

    protected $fillable = [
        'instrument_sub_topic_id',
        'matrix',
        'scope_type',
        'is_available',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $hidden = [
        'instrument_sub_topic_id',
        'deleted_at',
        'is_available',
    ];

    public function subTopic()
    {
        return $this->belongsTo(InstrumentSubTopic::class, 'instrument_sub_topic_id', 'id');
    }

    public function scopeIsType($query, $param)
    {
        return $query->where('scope_type', $param);
    }

    public function scopeIsAvailable($query)
    {
        return $query->where('is_available', true);
    }
}
