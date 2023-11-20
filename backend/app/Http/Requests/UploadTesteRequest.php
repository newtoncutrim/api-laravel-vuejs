<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
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
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'photo.required' => 'A foto é obrigatória.',
            'photo.image' => 'O arquivo deve ser uma imagem.',
            'photo.mimes' => 'O arquivo deve ser uma imagem nos formatos JPEG, PNG, JPG ou GIF.',
            'photo.max' => 'O tamanho máximo do arquivo é 2 MB.',
        ];
    }
}
