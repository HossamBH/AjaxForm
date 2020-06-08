<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContentRequest extends FormRequest
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
            'name' => 'required',
            'age' => 'required',
            'image' => 'required',
            'gender_id' => 'required'
        ];
    }

    public function messages()
    {
        return $messages = [
                'name.required' => 'Name is required',
                'age.required' => 'Age is required',
                'image.required' => 'Image is required',
                'gender_id.required' => 'Gender is required'
            ];
    }
}
