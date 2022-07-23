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
                
        if(isset($validated['type'])) {
            $data = Instrument::with('SubTopic.Topic.Period')
                    ->isType($validated['type'])
                    ->isAvailable()
                    ->paginate(10);
        }

        return $this->apiRespond('ok', $data);
    }

    public function store(StoreRequest $request) 
    {
        $validated = $request->validated();

        try {
            $data = Instrument::create($validated);
            return $this->apiRespond('ok', $data, 201);
        } catch (\Throwable $th) {
            return $this->apiRespond($th->getMessage(), [], 500);
        }
    }
}
