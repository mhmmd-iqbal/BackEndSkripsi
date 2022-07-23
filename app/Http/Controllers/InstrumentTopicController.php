<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstrumentTopic\IndexRequest;
use App\Http\Requests\InstrumentTopic\StoreRequest;
use App\Models\InstrumentTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class InstrumentTopicController extends Controller
{
    public function __construct()
    {
        if(!Gate::allows('isAdmin')){
            abort(401, 'Unauthorized');
        }
    }

    public function index(IndexRequest $request)
    {
        $validated = $request->validated(); 
        $data = InstrumentTopic::with('period')
                ->with('SubTopics.instruments')
                ->orderBy('period_id')->paginate(10);
                
        if(isset($validated['period_id'])) {
            $data = InstrumentTopic::with('period')
                    ->with('SubTopics.instruments')
                    ->where('period_id', $validated['period_id'])
                    ->orderBy('period_id')->paginate(10);
        }

        return $this->apiRespond('ok', $data, 200);
    }

    public function store(StoreRequest $request) 
    {
        $validated = $request->validated();

        try {
            $data = InstrumentTopic::create($validated);
            return $this->apiRespond('ok', $data, 201);
        } catch (\Throwable $th) {
            return $this->apiRespond($th->getMessage(), [], 500);
        }
    }
}
