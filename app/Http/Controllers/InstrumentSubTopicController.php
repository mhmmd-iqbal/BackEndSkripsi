<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstrumentSubTopic\StoreRequest;
use App\Models\InstrumentSubTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class InstrumentSubTopicController extends Controller
{
    public function __construct()
    {
        if(!Gate::allows('isAdmin')){
            abort(401, 'Unauthorized');
        }
    }

    public function store(StoreRequest $request) 
    {
        $validated = $request->validated();

        try {
            $data = InstrumentSubTopic::create($validated);
            return $this->apiRespond('ok', $data, 200);
        } catch (\Throwable $th) {
            return $this->apiRespond($th->getMessage(), [], 500);
        }
    }
}
