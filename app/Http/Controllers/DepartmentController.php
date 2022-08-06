<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\IndexRequest;
use App\Http\Requests\Department\StoreRequest;
use App\Http\Requests\Department\UpdateRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
    {
        $validated  = $request->validated();
        $pagination = $validated['pagination'] ?? 1;

        $data = $pagination ? 
                Department::with('user')->paginate(10) : 
                Department::with('user')->get();

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
            $data = Department::create($validated);
            return $this->apiRespond('ok', $data, 200);
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
        $data = Department::with('user')->find($id);

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
            $data = Department::find($id);

            if(!is_null($data)) {
                $data->update($validated);
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
            $data = Department::find($id);

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
