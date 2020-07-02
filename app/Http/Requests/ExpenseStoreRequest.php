<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'expense_title' => 'required|string|max:255',
            'expense_cost' => 'required|integer',
            'expense_details' => 'required|string|max:255',
            'created_at' => 'required|date',
        ];
    }
}
