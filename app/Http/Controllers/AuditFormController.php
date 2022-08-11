<?php

namespace App\Http\Controllers;

use App\Http\Requests\Audit\FulfillmentRequest;
use App\Http\Requests\Audit\IndexRequest;
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
        $period     = Period::where('id', $validated['period_id'])->first();
        $department = Department::where('id', $validated['department_id'])->first();
        $auditee    = $department->user;
        
        if(is_null($auditor) || is_null ($period) || is_null($department)) {
            return $this->apiRespond('Not Found ID', [], 404);
        }
        try {
            $data = [
                'department_id'             => $validated['department_id'],
                'period_id'                 => $validated['period_id'],
                'auditee_id'                => $auditee->id,
                'auditor_id'                => $validated['auditor_id'],
                'document_no'               => $validated['document_no'],
                'department_name'           => $department->name,
                'auditee_name'              => $auditee->name,
                'auditor_name'              => $auditor->name,
                'auditor_member_list_json'  => json_encode($validated['auditor_member_list_json']),
                'scope_type'                => $department->scope_type,
                'audit_type'                => $validated['audit_type'] ?? 'Lapangan',
                'audit_title'               => $validated['audit_title'],
                'audit_at'                  => $validated['audit_at'],
                'audit_standart'            => $validated['audit_standart']
            ];
    
            $result = AuditForm::create($data);
    
            return $this->apiRespond('ok', $result, 200);
        } catch (\Throwable $th) {
            return $this->apiRespond($th->getMessage(), [], 500);
        }
    }

    public function index(IndexRequest $request)
    {
        $validated = $request->validated();

        $pagination = $validated['pagination'] ?? true;

        if(Gate::allows('isAdmin') || Gate::allows('isManager') || Gate::allows('isAuditee') || Gate::allows('isAuditor')) {

            $data = new AuditForm();

            if(Gate::allows('isAuditee')) {
                // get result if login auditee 
                $data = $data->where('auditee_id', auth()->user()->id);
            } else if(Gate::allows('isAuditor')) {
                // get result if login auditor
                $data = $data->where('auditor_id', auth()->user()->id);
            }

            $data = isset($validated['period_id']) ? $data->where('period_id', $validated['period_id']) : $data;

            $data = $pagination ? $data->paginate(10) : $data->get();

        } else {
            abort(401, 'Unauthorized');
        }

        return $this->apiRespond('ok', $data);
    }

    public function show($id)
    {
        $audit          = AuditForm::find($id);
                            
        $topics         = InstrumentTopic::with(['subTopics' => function($sub_topic) use ($audit) {
                                $sub_topic->with(['instruments' => function($instrument) use ($audit){
                                    $instrument->isAvailable();
                                    $instrument->isType($audit->scope_type);
                                }]);
                                $sub_topic->whereHas('instruments');
                        }])
                        ->whereHas('subTopics', function($sub_topic) use ($audit){
                            $sub_topic->whereHas('instruments', function($instrument) use ($audit){
                                $instrument->isAvailable();
                                $instrument->isType($audit->scope_type);
                            });
                        })
                        ->where('period_id', $audit->period_id)
                        ->orderBy('id')
                        ->get();

        return $this->apiRespond('ok', [
            'audit'         => $audit,
            'topic'         => $topics
        ]);
    }

    public function result($id) {
        $audit          = AuditForm::find($id);
        $result         = AuditFormResult::where('audit_form_id', $audit->id)
                        ->with(['instrumentOrigin' => function($instrument) {
                            $instrument->with(['subTopic' => function($sub_topic) {
                                $sub_topic->with('topic');
                                $sub_topic->orderBy('instrument_topic_id');
                            }]);
                            $instrument->orderBy('instrument_sub_topic_id');
                        }])
                        ->get();
      

        return $this->apiRespond('ok', [
            'audit'         => $audit,
            'result'        => $result
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

    public function finishFulfillment($audit_id) {
        if(!Gate::allows('isAuditee')) {
            abort(401, 'Unauthorized');
        }

        $audit      = AuditForm::findOrFail($audit_id);
        $audit->update(['audit_status' => 2]);

        return $this->apiRespond('ok', [], 200);
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

    public function approval(Request $request, $audit_id);
}
