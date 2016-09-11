<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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
            'username'  => 'min:6|max:6|unique:users|required',
            'wdoc1' => 'min:2|max:30|required',
            'wdoc2' => 'min:2|max:30|required'
        ];
    }
}
