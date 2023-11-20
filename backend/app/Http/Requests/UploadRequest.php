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
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'image_path.required' => 'A foto é obrigatória.',
            'image_path.image' => 'O arquivo deve ser uma imagem.',
            'image_path.mimes' => 'O arquivo deve ser uma imagem nos formatos JPEG, PNG, JPG ou GIF.',
            'image_path.max' => 'O tamanho máximo do arquivo é 2 MB.',
        ];
    }
}
