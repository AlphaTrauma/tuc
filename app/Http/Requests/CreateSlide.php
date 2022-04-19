<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSlide extends FormRequest
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
            'title' => 'string|nullable',
            'ordering' => 'integer|required',
            'description' => 'string|nullable',
            'file' => 'image|required',
            'button_text' => 'string|nullable',
            'link' => 'string|required'
        ];
    }

    public function messages()
    {
        return [
            'title.string' => 'Некорректный заголовок слайда',
            'description.string' => 'Некорректное описание слайда',
            'file.required' => 'Изображение слайда не загружено',
            'file.image' => 'Загруженное изображение имеет неправильное расширение',
            'link.required' => 'Не указана ссылка для слайда',
            'link.url' => 'Указана ссылка в некорректном формате'
        ];
    }
}
