<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuizRequest extends FormRequest
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
            'title' => 'required|min:3',
            'description' => 'required|min:10',
            'discipline_id' => 'required|exists:disciplines,id',
            'image' => 'nullable|string',
            'type' => 'required|in:choice,descriptive'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'O campo de título é obrigatório',
            'title.min' => 'O campo título deve ter pelo menos :min caracteres',
            'description.required' => 'O campo de descrição é obrigatório',
            'description.min' => 'O campo descrição deve ter pelo menos :min caracteres',
            'discipline_id.required' => 'O campo de discipline_id é obrigatório.',
            'discipline_id.exists' => 'O discipline_id informado não foi encontrado no banco de dados.'
        ];
    }
}
