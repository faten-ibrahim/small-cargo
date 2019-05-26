<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => 'required|unique:users',
            'address' => 'required',
            'status' => 'required',
        ];

        // request()->validate([
        //     'name' => 'required',
        //     'email' => 'required|unique:users',
        //     'address' => 'required',
        //     'status' => 'required',
        // ]);
    }

    public function message()
    {
        [
            'name.required'=>'Please enter the name',
            'email.required'=>'Please enter the email',
            'email.unique'=>'This email is already exists',
            'address.required'=>'Please enter the address',
            'status.required'=>'Please select the status'


        ];

    }
}
