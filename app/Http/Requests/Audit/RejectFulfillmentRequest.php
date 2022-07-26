<?php

namespace App\Http\Requests\Audit;

use Illuminate\Foundation\Http\FormRequest;

class RejectFulfillmentRequest extends FormRequest
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
            "document_no" => 'string',
            "revision" => 'string',
            "category" => 'string',
            "finding_description" => 'string',
            "root_caused_Description" => 'string',
            "consequence_description" => 'string'
        ];
    }
}
