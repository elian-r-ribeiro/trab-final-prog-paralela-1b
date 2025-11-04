<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionOptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'text' => 'min:3',
            'image' => 'nullable|string',
            'is_correct' => 'boolean',
            'quiz_id' => 'exists:quizzes,id'
        ];
    }

    public function messages()
    {
        return [
            'text.min' => 'O texto deve ter pelo menos :min caracteres.',
            'quiz_id.exists' => 'O id da questão não existe.'
        ];
    }
}
