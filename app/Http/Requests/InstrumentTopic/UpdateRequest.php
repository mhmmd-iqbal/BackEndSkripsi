<?php

namespace App\Http\Requests\InstrumentTopic;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'period_id' => 'exists:periods,id',
            'name'      => 'string',
            'sub_topics'=> 'nullable',
            'sub_topics.*.action'   => 'in:update,store',
            'sub_topics.*.id'       => 'nullable|exists:instrument_sub_topics,id',
            'sub_topics.*.name'     => 'nullable|string'
        ];
    }
}
