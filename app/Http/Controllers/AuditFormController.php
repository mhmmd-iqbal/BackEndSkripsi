<?php

namespace App\Http\Controllers;

use App\Http\Requests\Audit\FulfillmentRequest;
use App\Http\Requests\Audit\RejectFulfillmentRequest;
use App\Http\Requests\Audit\StoreRequest;
use App\Models\AuditForm;
use App\Models\AuditFormResult;
use App\Models\AuditRejectDescription;
use App\Models\Department;
use App\Models\Instrument;
use App\Models\InstrumentTopic;
use App\Models\Period;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class AuditFormController extends Controller
{
    public function store(StoreRequest $request)
    {
        if(!Gate::allows('isAdmin')){
            abort(401, 'Unauthorized');
        }

        $validated = $request->validated();

        $auditor    = User::where('id', $validated['auditor_id'])->isRole('auditor')->first();
        $auditee    = User::where('id', $validated['auditee_id'])->isRole('auditee')->first();
        $period     = Period::where('id', $validated['period_id'])->first();
        $department = Department::where('id', $validated['department_id'])->first();
        
        if(is_null($auditor) || is_null ($period) || is_null($department)) {
            return $this->apiRespond('Not Found ID', [], 404);
        }

        try {
            $data = [
                'department_id'             => $validated['department_id'],
                'period_id'                 => $validated['period_id'],
                'auditee_id'                => $validated['auditee_id'],
                'auditor_id'                => $validated['auditor_id'],
                'document_no'               => $validated['document_no'],
                'department_name'           => $department->name,
                'auditee_name'              => $auditee->name,
                'auditor_name'              => $auditor->name,
                'auditor_member_list_json'  => json_encode($validated['auditor_member_list_json']),
                'scope_type'                => $department->scope_type,
                'audit_type'                => 'Lapangan',
                'audit_title'               => $validated['audit_title'],
                'audit_at'                  => Carbon::now()
            ];
    
            $result = AuditForm::create($data);
    
            return $this->apiRespond('ok', $result, 200);
        } catch (\Throwable $th) {
            return $this->apiRespond($th->getMessage(), [], 500);
        }
    }

    public function index()
    {
        if(Gate::allows('isAdmin') || Gate::allows('isManager')) {
            $data = AuditForm::paginate(10);
        } else if(Gate::allows('isAuditee')) {
            // get result if login auditee 
            $data = AuditForm::where('auditee_id', auth()->user()->id)->get();
        } else if(Gate::allows('isAuditor')) {
            // get result if login auditor
            $data = AuditForm::where('auditor_id', auth()->user()->id )->get();
        } else {
            abort(401, 'Unauthorized');
        }

        return $this->apiRespond('ok', $data);
    }

    public function show($id)
    {
        $audit          = AuditForm::find($id);
        
        $instruments    = Instrument::isAvailable()
                            ->isType($audit->scope_type)
                            ->with('subTopic.topic') 
                            ->whereHas('subTopic' , function($q) use ($audit) {
                                $q->whereHas('topic' , function($qq) use ($audit) {
                                    $qq->where('period_id', $audit->period_id);
                                });
                                $q->orderBy('instrument_topic_id');
                            })
                            ->orderBy('instrument_sub_topic_id')
                            ->get();
        
        return $this->apiRespond('ok', [
            'audit'         => $audit,
            'instrument'    => $instruments
        ]);
    }

    public function fulfillment(FulfillmentRequest $request, $audit_id, $instrument_id)
    {
        if(!Gate::allows('isAuditee')) {
            abort(401, 'Unauthorized');
        }

        $validated    = $request->validated();
        
        if(isset($validated['file'])) {
            $uploadedFile = $validated['file'];
            $filename     = time().$uploadedFile->getClientOriginalName();
            
            Storage::disk('public')->put($filename,file_get_contents($uploadedFile), 'public');
            
            $url = Storage::disk('public')->url($filename);
        }
        
        try {
            $audit      = AuditForm::findOrFail($audit_id);
            $instrument = Instrument::findOrFail($instrument_id);

            $data       = AuditFormResult::updateOrCreate([
                'audit_form_id' => $audit->id,
                'instrument_id' => $instrument->id 
            ],
            [
                'instrument'    => $instrument->matrix,
                'description'   => $validated['description'],
                'evidence_file' => $url ?? null
            ]);

            return $this->apiRespond('ok', $data, 200);
        } catch (\Throwable $th) {
            return $this->apiRespond($th->getMessage(), [], 500);
        }    
    }

    public function approve($audit_id, $instrument_id)
    {
        if(!Gate::allows('isAuditor')) {
            abort(401, 'Unauthorized');
        }

        $audit      = AuditForm::findOrFail($audit_id);
        $instrument = Instrument::findOrFail($instrument_id);

        try {
            $data       = AuditFormResult::updateOrCreate([
                'audit_form_id' => $audit->id,
                'instrument_id' => $instrument->id 
            ],
            [
                'instrument'    => $instrument->matrix,
                'approval'      => 1
            ]);

            return $this->apiRespond('ok', $data, 200);
        } catch (\Throwable $th) {
            return $this->apiRespond($th->getMessage(), [], 500);
        }
    }

    public function reject(RejectFulfillmentRequest $request, $audit_id, $instrument_id)
    {
        if(!Gate::allows('isAuditor')) {
            abort(401, 'Unauthorized');
        }
        $validated    = $request->validated();
        
        try {
            $audit      = AuditForm::findOrFail($audit_id);
            $instrument = Instrument::findOrFail($instrument_id);
            $department = $audit->department;
            $auditor    = $audit->auditor;
            $auditee    = $audit->auditee;
            $period     = $audit->period;


            $data       = AuditFormResult::updateOrCreate([
                'audit_form_id' => $audit->id,
                'instrument_id' => $instrument->id 
            ],
            [
                'instrument'    => $instrument->matrix,
                'approval'      => 0
            ]);

            AuditRejectDescription::updateOrCreate([
                'department_id'             => $department->id,
                'period_id'                 => $period->id,
                'audit_form_id'             => $audit->id,
                'auditee_id'                => $auditee->id,
                'auditor_id'                => $auditor->id,
                'instrument_id'             => $instrument->id,
            ],[
                'revision'                  => $validated['revision'],
                'document_no'               => $validated['document_no'],
                'category'                  => $validated['category'],
                'auditee_name'              => $auditee->name,
                'auditor_name'              => $auditor->name,
                'instrument_topic_name'     => $instrument->subTopic->topic->name,
                'finding_description'       => $validated['finding_description'],
                'root_caused_Description'   => $validated['root_caused_Description'],
                'consequence_description'   => $validated['consequence_description'],  
                'scope_type'                => $audit->scope_type
            ]);

            return $this->apiRespond('ok', $data, 200);
        } catch (\Throwable $th) {
            return $this->apiRespond($th->getMessage(), [], 500);
        }
    }
}
