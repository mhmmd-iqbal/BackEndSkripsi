<?php

namespace App\Http\Requests\Audit;

use Illuminate\Foundation\Http\FormRequest;

class FulfillmentRequest extends FormRequest
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
            'instrument_id'  => 'exists:instruments,id',
            'description'    => 'nullable|string',
            'file'           => 'nullable|file',
        ];
    }
}
