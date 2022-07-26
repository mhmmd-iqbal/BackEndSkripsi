<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateProfile;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Gate::allows('isAdmin')){
            abort(401, 'Unauthorized');
        }

        $data = User::paginate(10);

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
        if(!Gate::allows('isAdmin')){
            abort(401, 'Unauthorized');
        }

        $validated = $request->validated();

        try {
            if(isset($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            }

            $data = User::create($validated);
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
        if(!Gate::allows('isAdmin')){
            abort(401, 'Unauthorized');
        }

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
        if(!Gate::allows('isAdmin')){
            abort(401, 'Unauthorized');
        }

        $validated = $request->validated();
        
        try {
            $data = User::findOrFail($id);
            
            $data->update([
                'name'      => $validated['name'] ?? $data->name,
                'email'     => $validated['email'] ?? $data->email,
                'nip'       => $validated['nip'] ?? $data->nip,
                'role'      => $validated['role'] ?? $data->role,
                'password'  => isset($validated['password']) ? bcrypt($validated['password']) : $data->password 
            ]);
            
            return $this->apiRespond('ok', $data, 200);

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
        if(!Gate::allows('isAdmin')){
            abort(401, 'Unauthorized');
        }

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


    public function getProfile()
    {
        if(!auth()->user()) {
            abort(403, 'Forbidden');
        }

        return $this->apiRespond('ok', auth()->user(), 200);
    }

    public function updateProfile(UpdateProfile $request)
    {
        if(!auth()->user()) {
            abort(403, 'Forbidden');
        }

        $validated = $request->validated();

        if($validated['password'] !== $validated['retype_password']) {
            return $this->apiRespond('Password dan Retype password tidak sama', [], 400);
        }

        try {
            $data = User::findOrFail(auth()->user()->id);
            
            $data->update([
                'name'      => $validated['name'] ?? $data->name,
                'email'     => $validated['email'] ?? $data->email,
                'nip'       => $validated['nip'] ?? $data->nip,
                'password'  => isset($validated['password']) ? bcrypt($validated['password']) : $data->password 
            ]);
            
            return $this->apiRespond('ok', $data, 200);

        } catch (\Throwable $th) {
            return $this->apiRespond($th->getMessage(), [], 500);
        }

    }
}
