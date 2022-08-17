<?php

namespace App\Http\Controllers;

use App\Models\AuditForm;
use App\Models\AuditRejectDescription;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class ReportController extends Controller
{
    public function totalData()
    {
        if(!Gate::allows('isAdmin') || !Gate::allows('isManager')) {
            abort(401, 'Unauthorized');
        }

        $user       = new User();
        $department = new Department();

        $manager = $user->isRole('manager')->count();
        $auditor = $user->isRole('auditor')->count();
        $auditee = $user->isRole('auditee')->count();
        $academic       = $department->where('scope_type', 'academic')->count();
        $non_academic   = $department->where('scope_type', 'non_academic')->count();


        return $this->apiRespond('ok', [
            'manager'   => $manager,
            'auditor'   => $auditor,
            'auditee'   => $auditee,
            'academic'      => $academic,
            'non_academic'  => $non_academic,
        ], 200);
    }

    public function auditChart()
    {
        if(!Gate::allows('isAdmin')){
            abort(401, 'Unauthorized');
        }

        $audit          = new AuditForm();
        $rejection      = new AuditRejectDescription();

        $audit_chart = [
            [
                'label' => 'Academic',
                'value' => $audit->where('scope_type', 'academic')->count()
            ],
            [
                'label' => 'Non Academic',
                'value' => $audit->where('scope_type', 'non_academic')->count(),
            ]
        ];

        $rejection_chart = [
            [
                'label' => 'KTS Mayor',
                'value' => $rejection->where('category', 'kts_mayor')->count()
            ],
            [
                'label' => 'KTS Minor',
                'value' => $rejection->where('category', 'kts_minor')->count()
            ],
            [
                'label' => 'Observasi',
                'value' => $rejection->where('category', 'observasi')->count()
            ],
        ];

        return $this->apiRespond('ok', [
            'audit'     => $audit_chart,
            'rejection' => $rejection_chart,
        ]);

    }
}
