<?php

namespace App\Http\Requests\InstrumentSubTopic;

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
            'instrument_topic_id'   => 'exists:instrument_topics,id',
            'name'                  => 'string'
        ];
    }
}
