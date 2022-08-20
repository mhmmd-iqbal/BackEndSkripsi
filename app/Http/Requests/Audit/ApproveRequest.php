<?php

namespace App\Http\Requests\Audit;

use Illuminate\Foundation\Http\FormRequest;

class ApproveRequest extends FormRequest
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
            'positive_issue'                 => 'required|array',
            'conclusion'                     => 'required|array',
            'data.*.instrument_id'           => 'required',
            'data.*.approve'                 => 'required',
            "data.*.category"                => 'nullable|string|required_if:data.*.approve,false',
            "data.*.finding_description"     => 'nullable|string|required_if:data.*.approve,false',
            "data.*.root_caused_description" => 'nullable|string|required_if:data.*.approve,false',
            "data.*.consequence_description" => 'string|nullable|required_if:data.*.approve,false'
        ];
    }
}
