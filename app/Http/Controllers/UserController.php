<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorize('isAdmin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::get();

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
            if(isset($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            }

            $data = User::create($validated);
            return $this->apiRespond('ok', $data, 201);
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
        $data = User::find($id);

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
            $data = User::find($id);

            if(isset($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            }
            
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
            $data = User::find($id);

            if(!is_null($data)) {
                $data->delete();
                return $this->apiRespond('ok', [], 200);
            }
            return $this->apiRespond('Not found', [], 404);
        } catch (\Throwable $th) {
            return $this->apiRespond($th->getMessage(), [], 500);
        }
    }

    public function resetPassword()
    {
        
    }
}
