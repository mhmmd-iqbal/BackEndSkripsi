<?php

namespace App\Http\Controllers;

use App\Http\Requests\Period\StoreRequest;
use App\Http\Requests\Period\UpdateRequest;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PeriodController extends Controller
{
    public function __construct()
    {
        if(!Gate::allows('isAdmin')){
            abort(401, 'Unauthorized');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Period::get();

        return $this->apiRespond('ok', $data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        try {
            if($validated['period_start'] < $validated['period_end']) {
                $data = Period::create($validated);
                return $this->apiRespond('ok', $data, 200);
            } else {
                return $this->apiRespond('Request tidak sesuai', [], 400);                
            }
        } catch (\Throwable $th) {
            return $this->apiRespond($th->getMessage(), [], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Period::find($id);

        if(!is_null($data)) {
            return $this->apiRespond('ok', $data, 200);
        }
        return $this->apiRespond('Not found', [], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();
        
        try {
            $data = Period::find($id);

            if(!is_null($data)) {
                if($validated['period_start'] >= $validated['period_end']) {
                    return $this->apiRespond('Request tidak sesuai', [], 400);                
                }
                
                $data = $data->update([
                    'name'          => $validated['name'] ?? $data->name,
                    'period_start'  => $validated['period_start'] ?? $data->period_start,
                    'period_end'    => $validated['period_end'] ?? $data->period_end,
                ]);
                return $this->apiRespond('ok', $data, 200);
            }
            return $this->apiRespond('Not found', [], 404);
        } catch (\Throwable $th) {
            return $this->apiRespond($th->getMessage(), [], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = Period::find($id);

            if(!is_null($data)) {
                $data->delete();
                return $this->apiRespond('ok', [], 200);
            }
            return $this->apiRespond('Not found', [], 404);
        } catch (\Throwable $th) {
            return $this->apiRespond($th->getMessage(), [], 500);
        }
    }
}
