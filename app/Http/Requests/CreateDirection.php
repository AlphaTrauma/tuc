<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDirection extends FormRequest
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
            'title' => 'string|required',
            'description' => 'string|max:255|required',
            'file' => 'image|required',
            'html' => 'string|nullable'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Не заполнено название направления',
            'title.string' => 'Некорректное название направления',
            'description.required' => 'Не заполнено краткое описание направления',
            'description.string' => 'Некорректное описание',
            'description.max' => 'Длина краткого описания не должна превышать 255 символов',
            'file.required' => 'Изображение не загружено',
            'file.image' => 'Загруженное изображение имеет неправильное расширение'
        ];
    }
}
