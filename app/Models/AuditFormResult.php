<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditFormResult extends Model
{
    use HasFactory;

    protected $table = 'audit_form_results';

    protected $fillable = [
        'audit_form_id',
        'instrument_id',
        'instrument',
        'description',
        'evidence_file',
        'approval'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $hidden = [
        'audit_form_id',
        'instrument_id',
    ];

    public function auditForm()
    {
        return $this->belongsTo(AuditForm::class, 'audit_form_id', 'id');
    }

    public function instrument()
    {
        return $this->belongsTo(Instrument::class, 'instrument_id', 'id');
    }
}
