<?php

namespace App\Http\Controllers;

use App\Http\Requests\Instrument\IndexRequest;
use App\Http\Requests\Instrument\StoreRequest;
use App\Models\Instrument;
use Illuminate\Http\Request;

class InstrumentController extends Controller
{
    public function index(IndexRequest $request)
    {
        $validated = $request->validated();

        $data = Instrument::with('SubTopic.Topic.Period')
                ->isAvailable()
                ->paginate(10);
                
        if(isset($validated['scope_type'])) {
            $data = Instrument::with('SubTopic.Topic.Period')
                    ->isType($validated['scope_type'])
                    ->isAvailable()
                    ->paginate(10);
        }

        return $this->apiRespond('ok', $data);
    }

    public function store(StoreRequest $request) 
    {
        $validated = $request->validated();

        try {
            foreach ($validated['instruments'] as $instrument) {
                $data[] = Instrument::create([
                    'instrument_sub_topic_id'   => $validated['instrument_sub_topic_id'],
                    'scope_type'                => $validated['scope_type'],
                    'matrix'                    => $instrument['matrix'],
                    'is_available'              => $instrument['is_available']
                ]);  
            }

            return $this->apiRespond('ok', $data, 200);
        } catch (\Throwable $th) {
            return $this->apiRespond($th->getMessage(), [], 500);
        }
    }
}
