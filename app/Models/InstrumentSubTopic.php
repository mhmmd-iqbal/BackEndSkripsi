<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumentSubTopic extends Model
{
    use HasFactory;

    protected $table = 'instrument_sub_topics';

    protected $fillable = [
        'instrument_topic_id',
        'name',
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

    public function Topic()
    {
        return $this->belongsTo(InstrumentTopic::class, 'instrument_topic_id', 'id');
    }

    public function Instruments()
    {
        return $this->hasMany(Instrument::class, 'instrument_sub_topic_id', 'id');
    }
}
