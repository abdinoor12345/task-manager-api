<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tasks')->where(function ($query) {
                    return $query->where('due_date', $this->due_date);
                }),
            ],

            'due_date' => [
                'required',
                'date',
                'after_or_equal:today'
            ],

            'priority' => [
                'required',
                Rule::in(['low', 'medium', 'high'])
            ],
        ];
    }

    public function messages()
    {
        return [
            'title.unique' => 'A task with this title already exists for this due date.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422));
    }
}
