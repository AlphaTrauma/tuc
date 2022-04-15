<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDirection extends FormRequest
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
            'file' => 'image|nullable',
            'html' => 'string|nullable'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Не заполнено название направления',
            'title.string' => 'Некорректный заголовок слайда',
            'description.required' => 'Не заполнено краткое описание направления',
            'description.string' => 'Некорректное описание',
            'description.max' => 'Длина краткого описания не должна превышать 255 символов',
            'file.image' => 'Загруженное изображение имеет неправильное расширение'
        ];
    }
}
