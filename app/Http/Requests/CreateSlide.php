<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class CreateSlide extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
            'description' => 'string|nullable',
            'image' => 'image|required',
            'button_text' => 'string|nullable',
            'link' => 'string|url|required'
        ];
    }

    public function messages()
    {
        return [
            'title.string' => 'Некорректный заголовок слайда',
            'description.string' => 'Некорректное описание слайда',
            'image.required' => 'Изображение слайда не загружено',
            'image.image' => 'Загруженное изображение имеет неправильное расширение',
            'link.required' => 'Не указана ссылка для слайда',
            'link.url' => 'Указана ссылка в некорректном формате'
        ];
    }
}
