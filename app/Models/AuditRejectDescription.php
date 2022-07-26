<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditRejectDescription extends Model
{
    use HasFactory;

    protected $table = 'audit_reject_descriptions';
    
    protected $fillable = [
        'department_id',
        'period_id',
        'audit_form_id',
        'auditee_id',
        'auditor_id',
        'instrument_id',
        'revision',
        'document_no',
        'category',
        'auditee_name',
        'auditor_name',
        'instrument_topic_name',
        'finding_description',
        'root_caused_Description',
        'consequence_description',
        'action_plan_description',
        'scope_type'
    ];

    protected $hidden = [
        'audit_form_id',
        'department_id',
        'period_id',
        'auditee_id',
        'auditor_id',
        'instrument_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function auditForm()
    {
        return $this->belongsTo(AuditForm::class, 'audit_form_id', 'id');
    }
    
    public function instrument()
    {
        return $this->belongsTo(Instrument::class, 'instrument_id', 'id');
    }

    public function auditor()
    {
        return $this->belongsTo(User::class, 'auditor_id', 'id');
    }

    public function auditee()
    {
        return $this->belongsTo(User::class, 'auditee_id', 'id');
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
