<?php

namespace App\Http\Requests\Instrument;

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
            'instrument_sub_topic_id'   => 'exists:instrument_sub_topics,id',
            'matrix'                    => 'string',
            'audit_type'                => 'in:academic,non_academic',
            'is_available'              => 'boolean'
        ];
    }
}
