<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductRequest extends FormRequest
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
            'name' => 'filled|string',
            'img' => 'filled|mimes:png,jpg,jpeg,webp|max:10000',
            'gallery' => 'filled',
            'gallery.*' => 'filled|mimes:jpeg,jpg,png,webp|max:10000',
            'price' => 'filled|numeric',
            'description' => 'filled|string',
            'discount' => 'filled|numeric|between:0,100',
            'stock' => 'filled|numeric',
            'category_id' => 'filled|exists:categories,id',
            'sub_category_id' => 'filled|' . Rule::exists('sub_categories', 'id')->where('category_id', request('category_id')),
            'brand_id' => Rule::when(
                request()->has('sub_category_id'),
                [
                    'filled',
                    Rule::exists('brand_sub_categories', 'brand_id')->where('sub_category_id', request('sub_category_id'))
                ],
                [
                    'filled',
                    Rule::exists('brand_categories', 'brand_id')->where('category_id', request('category_id'))
                ]
            ),
            'attributes' => 'filled|array',
            'attributes.*' => 'array|size:2',
            'attributes.*.attr_name' => 'required|string|distinct',
            'attributes.*.attr_val' => 'required|array',
            'attributes.*.attr_val.*' => 'required|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => $validator->errors()
        ], 422));
    }
}
