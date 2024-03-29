<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class ProductRequest extends FormRequest
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
            "name" => "required|max:25|min:5",
            "description" => "required|max:255|min:5",
            "status" => "required|max:3",
            "category_id" => "required",
            "quantity"=> "integer",
            "images"=>"required|array|min:2",
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
