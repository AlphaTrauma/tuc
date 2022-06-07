<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateLead extends FormRequest
{

    protected $redirect = '/send';
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
            'name' => 'string|nullable',
            'comment' => 'string|max:255|nullable',
            'phone' => 'string|required|regex:/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){6,14}(\s*)?$/',
            'email' => 'string|email|nullable',
            'page' => 'string|nullable',
            'fax' => 'prohibited|nullable',
            'theme' => 'prohibited|nullable',
            'contact' => 'prohibited|nullable'
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'Поле имени заполнено некорректно',
            'comment.max' => 'Слишком длинный текст комментария',
            'comment.string' => 'Поле комментария заполнено некорректно',
            'phone.required' => 'Оставьте свой номер телефона, чтобы мы могли с вами связаться',
            'phone.regex' => 'Введите корректный номер телефона',
            'email.email' => 'Невалидный адрес электронной почты',
            'fax.prohibited' => 'Не удалось отправить заявку',
            'theme.prohibited' => 'Не удалось отправить заявку',
            'contact.prohibited' => 'Не удалось отправить заявку',
        ];
    }
}
