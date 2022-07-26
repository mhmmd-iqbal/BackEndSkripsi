<?php

namespace App\Http\Requests\Audit;

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
            'department_id'     => 'exists:departments,id',
            'period_id'         => 'exists:periods,id',
            'auditor_id'        => 'exists:users,id',
            'auditee_id'        => 'exists:users,id',
            'document_no'       => 'string',
            'auditor_member_list_json'  => 'nullable',
            'audit_title'       => 'string'
        ];
    }
}
