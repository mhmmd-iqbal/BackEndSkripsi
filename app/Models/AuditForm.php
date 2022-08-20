<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditForm extends Model
{
    use HasFactory;

    protected $table = 'audit_forms';

    protected $fillable = [
        'department_id',
        'period_id',
        'auditee_id',
        'auditor_id',
        'document_no',
        'revision',
        'department_name',
        'auditee_name',
        'auditor_name',
        'auditor_member_list_json',
        'scope_type',
        'audit_type',
        'audit_title',
        'audit_status',
        'audit_standart',
        'audit_at',
        'json_positive_issue',
        'json_conclusion'
    ];

    protected $hidden = [
        'department_id',
        'period_id',
        'auditee_id',
        'auditor_id',
        'auditor_member_list_json',
        'json_positive_issue',
        'json_conclusion'
    ];

    protected $casts = [
        'created_at'    => 'datetime:Y-m-d H:i:s',
        'updated_at'    => 'datetime:Y-m-d H:i:s',
        'audit_at'      => 'datetime:Y-m-d H:i:s',
        'audit_status'  => 'integer'
    ];

    protected $appends = [
        'auditor_member_list',
        'conclusion',
        'positive_issue'
    ];

    protected $with = [
        'department',
        'auditor',
        'period'
    ];

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

    public function results()
    {
        return $this->hasMany(AuditFormResult::class, 'audit_form_id', 'id');
    }

    public function reject()
    {
        return $this->hasMany(AuditRejectDescription::class, 'audit_form_id', 'id');
    }

    public function scopeIsStatus($query, $param)
    {
        return $query->where('audit_status', $param);
    }

    public function getAuditorMemberListAttribute()
    {
        return json_decode($this->auditor_member_list_json);
    }

    public function getConclusionAttribute()
    {
        return json_decode($this->json_conclusion);
    }

    public function getPositiveIssueAttribute()
    {
        return json_decode($this->json_positive_issue);
    }
}
