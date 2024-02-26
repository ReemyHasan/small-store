<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator as ResponseValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryRequest extends FormRequest
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
            "created_by"=> "required",
            'image' => 'required|image|mimes:png,jpg,gif|max:2765|dimensions:width<=3840,height<=2160',
            'supercategory_id'=>[
                function ($attribute, $value, $fail) {
                    $validator = Validator::make([$attribute => $value], [
                        $attribute => 'exists:categories,id',
                    ]);

                    if ($validator->fails() && $value != 0) {
                        $fail('The selected supercategory is invalid.');
                    }
                },
            ],
        ];
    }
    public function failedValidation(ResponseValidator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors(),

        ]));
    }
}
