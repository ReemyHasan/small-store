<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductRequest extends FormRequest
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
            "name" => "max:25|min:5",
            "description" => "max:255|min:5",
            "status" => "max:3",
            "price" => "regex:/^[0-9]+(\.[0-9][0-9]?)?$/",
            "quantity"=> "integer",
            'images.*' => 'image|mimes:png,jpg,gif|max:2765|dimensions:width<=3840,height<=2160',
        ];
    }
    // public function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json([
    //         'success' => false,
    //         'message' => 'Validation errors',
    //         'data' => $validator->errors()
    //     ]));
    // }
}
