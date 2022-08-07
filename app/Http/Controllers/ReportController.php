<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class ReportController extends Controller
{
    public function totalData()
    {
        if(!Gate::allows('isAdmin')){
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
}
