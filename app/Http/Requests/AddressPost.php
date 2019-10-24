<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressPost extends FormRequest
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
          'name' => ['required', 'string'],
          'address' => ['required', 'string'],
          'tel' => ['required', 'regex:/\A\d{2,4}-?\d{2,4}-?\d{4}\z/'],
      ];
    }
}
