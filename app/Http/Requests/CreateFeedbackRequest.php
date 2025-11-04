<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFeedbackRequest extends FormRequest
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
            'text' => 'required|min:3',
            'quiz_id' => 'required|exists:quizzes,id',
            'image' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'text.required' => 'O texto do feedback é obrigatório.',
            'text.min' => 'O texto deve ter pelo menos :min caracteres.',
            'quiz_id.required' => 'O id da questão é obrigatório.',
            'quiz_id.exists' => 'O id da questão não existe.'
        ];
    }
}
