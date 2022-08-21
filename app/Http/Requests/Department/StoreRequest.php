<?php

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'level'         => 'nullable|in:D1,D2,D3,D4',
            'name'          => 'string',
            'scope_type'    => 'in:academic,non_academic',
            'user_id'       => 'exists:users,id',
            'major_id'      => 'required_if:scope_type,academic'
        ];
    }
}
